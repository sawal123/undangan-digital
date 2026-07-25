<?php

namespace App\Services;

use App\Models\AuthActivityLog;
use App\Models\User;
use App\Notifications\SecurityAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class AuthActivityLogger
{
    public function __construct(private readonly AuthRiskAnalyzer $riskAnalyzer) {}

    public function log(
        string $eventType,
        string $status = 'success',
        ?User $user = null,
        ?string $email = null,
        array $metadata = [],
        ?Request $request = null,
        ?string $riskLevel = null,
        array $riskReasons = []
    ): ?AuthActivityLog {
        try {
            $request ??= request();
            $email = strtolower($email ?? $user?->email ?? '');
            $analysis = $riskLevel
                ? ['risk_level' => $riskLevel, 'reasons' => $riskReasons]
                : $this->riskAnalyzer->analyze($eventType, $user, $email, $request);

            $log = AuthActivityLog::create([
                'user_id' => $user?->id,
                'email' => $email ?: null,
                'event_type' => $eventType,
                'status' => $status,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'request_path' => $request->path(),
                'request_method' => $request->method(),
                'risk_level' => $analysis['risk_level'],
                'risk_reasons' => $analysis['reasons'],
                'metadata' => $this->maskSensitiveMetadata($metadata),
                'occurred_at' => now(),
            ]);

            if ($user && in_array($analysis['risk_level'], [AuthActivityLog::RISK_HIGH, AuthActivityLog::RISK_CRITICAL], true)) {
                $user->forceFill(['security_risk_level' => $analysis['risk_level']])->saveQuietly();
            }

            if (in_array($analysis['risk_level'], [AuthActivityLog::RISK_HIGH, AuthActivityLog::RISK_CRITICAL], true)) {
                $this->notifyOwners($log);
            }

            return $log;
        } catch (\Throwable $exception) {
            Log::warning('Auth activity logging failed.', [
                'event_type' => $eventType,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function maskSensitiveMetadata(array $metadata): array
    {
        return collect($metadata)
            ->reject(fn ($value, $key) => $this->isForbiddenKey((string) $key))
            ->map(function ($value, $key) {
                if ($this->isSensitiveKey((string) $key)) {
                    return '[redacted]';
                }

                if (is_array($value)) {
                    return $this->maskSensitiveMetadata($value);
                }

                return $value;
            })
            ->all();
    }

    protected function isForbiddenKey(string $key): bool
    {
        $key = strtolower($key);

        return in_array($key, ['authorization', 'cookie', 'set-cookie'], true);
    }

    protected function isSensitiveKey(string $key): bool
    {
        $key = strtolower($key);

        return str_contains($key, 'password')
            || str_contains($key, 'token')
            || str_contains($key, 'otp')
            || str_contains($key, 'csrf')
            || str_contains($key, 'secret')
            || str_contains($key, 'session')
            || str_contains($key, 'midtrans');
    }

    protected function notifyOwners(AuthActivityLog $log): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        $cooldownKey = 'security-alert:'.$log->event_type.':'.$log->risk_level.':'.($log->ip_address ?? 'unknown').':'.($log->email ?? 'none');

        if (Cache::has($cooldownKey)) {
            return;
        }

        Cache::put($cooldownKey, true, now()->addMinutes((int) config('security.security_alert_cooldown_minutes', 30)));

        User::role('Owner')
            ->get()
            ->each(fn (User $owner) => $owner->notify(new SecurityAlertNotification($log)));

        if (config('security.security_alert_email_enabled') && config('security.security_alert_email')) {
            Notification::route('mail', config('security.security_alert_email'))
                ->notify(new SecurityAlertNotification($log));
        }
    }
}
