<?php

namespace App\Services;

use App\Models\AuthActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuthRiskAnalyzer
{
    /**
     * @return array{risk_level: string, reasons: array<int, string>}
     */
    public function analyze(string $eventType, ?User $user = null, ?string $email = null, ?Request $request = null): array
    {
        $request ??= request();
        $ip = $request->ip();
        $email = $email ? strtolower($email) : null;
        $reasons = [];
        $risk = AuthActivityLog::RISK_LOW;

        if ($eventType === AuthActivityLog::EVENT_LOGIN_FAILED && $ip) {
            $recentIpFailures = $this->countRecent(['ip_address' => $ip, 'event_type' => AuthActivityLog::EVENT_LOGIN_FAILED], 15);
            $recentEmailFailures = $email ? $this->countRecent(['email' => $email, 'event_type' => AuthActivityLog::EVENT_LOGIN_FAILED], 15) : 0;

            if ($recentIpFailures >= 20) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_CRITICAL);
                $reasons[] = 'lebih dari 20 login gagal dari IP yang sama dalam 15 menit';
            } elseif ($recentIpFailures >= 10) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);
                $reasons[] = 'banyak login gagal dari IP yang sama';
            }

            if ($recentEmailFailures >= 10) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);
                $reasons[] = 'akun mengalami banyak login gagal';
            }

            $distinctEmails = AuthActivityLog::query()
                ->where('ip_address', $ip)
                ->where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)
                ->where('occurred_at', '>=', Carbon::now()->subMinutes(15))
                ->distinct()
                ->count('email');

            if ($distinctEmails >= 8) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);
                $reasons[] = 'satu IP mencoba banyak alamat email';
            }
        }

        if ($eventType === AuthActivityLog::EVENT_REGISTER && $ip) {
            $registrations = $this->countRecent(['ip_address' => $ip, 'event_type' => AuthActivityLog::EVENT_REGISTER], 60);

            if ($registrations >= 5) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);
                $reasons[] = 'banyak registrasi dari IP yang sama';
            } elseif ($registrations >= 3) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_MEDIUM);
                $reasons[] = 'beberapa registrasi dari IP yang sama';
            }

            if ($this->isDisposableEmail($email)) {
                $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);
                $reasons[] = 'alamat email dari disposable domain yang dikonfigurasi';
            }
        }

        if (in_array($eventType, [AuthActivityLog::EVENT_ADMIN_ACCESS_DENIED, AuthActivityLog::EVENT_OWNERSHIP_VIOLATION], true)) {
            $risk = $this->maxRisk($risk, AuthActivityLog::RISK_HIGH);

            if ($eventType === AuthActivityLog::EVENT_ADMIN_ACCESS_DENIED && $user?->created_at?->greaterThan(Carbon::now()->subDay())) {
                $reasons[] = 'akun baru mencoba membuka route admin';
            }

            if ($eventType === AuthActivityLog::EVENT_OWNERSHIP_VIOLATION && $user) {
                $violations = $this->countRecent([
                    'user_id' => $user->id,
                    'event_type' => AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
                ], 15);

                if ($violations >= 3) {
                    $risk = $this->maxRisk($risk, AuthActivityLog::RISK_CRITICAL);
                    $reasons[] = 'ownership violation berulang dalam waktu singkat';
                }
            }
        }

        if ($user && ! $user->hasVerifiedEmail() && in_array($eventType, [
            AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
            AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
        ], true)) {
            $risk = $this->maxRisk($risk, AuthActivityLog::RISK_MEDIUM);
            $reasons[] = 'email belum diverifikasi tetapi melakukan aktivitas sensitif';
        }

        return [
            'risk_level' => $risk,
            'reasons' => array_values(array_unique($reasons)),
        ];
    }

    protected function countRecent(array $conditions, int $minutes): int
    {
        return AuthActivityLog::query()
            ->where($conditions)
            ->where('occurred_at', '>=', Carbon::now()->subMinutes($minutes))
            ->count();
    }

    protected function isDisposableEmail(?string $email): bool
    {
        if (! $email || ! config('security.block_disposable_email')) {
            return false;
        }

        $domain = strtolower((string) str($email)->after('@'));

        return in_array($domain, config('security.disposable_domains', []), true);
    }

    protected function maxRisk(string $current, string $candidate): string
    {
        $rank = [
            AuthActivityLog::RISK_LOW => 0,
            AuthActivityLog::RISK_MEDIUM => 1,
            AuthActivityLog::RISK_HIGH => 2,
            AuthActivityLog::RISK_CRITICAL => 3,
        ];

        return ($rank[$candidate] ?? 0) > ($rank[$current] ?? 0) ? $candidate : $current;
    }
}
