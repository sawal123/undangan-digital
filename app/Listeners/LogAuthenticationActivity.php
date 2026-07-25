<?php

namespace App\Listeners;

use App\Models\AuthActivityLog;
use App\Models\User;
use App\Services\AuthActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;

class LogAuthenticationActivity
{
    public function __construct(private readonly AuthActivityLogger $logger) {}

    public function handle(object $event): void
    {
        if ($event instanceof Login) {
            $event->user->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
                'last_user_agent' => request()->userAgent(),
            ])->saveQuietly();

            $this->logger->log(AuthActivityLog::EVENT_LOGIN_SUCCESS, user: $event->user);

            return;
        }

        if ($event instanceof Failed) {
            $this->logger->log(
                AuthActivityLog::EVENT_LOGIN_FAILED,
                'failed',
                $event->user instanceof User ? $event->user : null,
                $event->credentials['email'] ?? null
            );

            return;
        }

        if ($event instanceof Logout) {
            $this->logger->log(AuthActivityLog::EVENT_LOGOUT, user: $event->user instanceof User ? $event->user : null);

            return;
        }

        if ($event instanceof Lockout) {
            $this->logger->log(
                AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
                'blocked',
                auth()->user(),
                $event->request->input('email'),
                ['throttle_key' => $event->request->input('email')],
                $event->request,
                AuthActivityLog::RISK_HIGH,
                ['rate limit terpicu']
            );

            return;
        }

        if ($event instanceof Registered) {
            $this->logger->log(AuthActivityLog::EVENT_REGISTER, user: $event->user instanceof User ? $event->user : null);

            return;
        }

        if ($event instanceof PasswordReset) {
            $this->logger->log(AuthActivityLog::EVENT_PASSWORD_RESET_COMPLETED, user: $event->user instanceof User ? $event->user : null);

            return;
        }

        if ($event instanceof Verified) {
            $this->logger->log(AuthActivityLog::EVENT_EMAIL_VERIFIED, user: $event->user instanceof User ? $event->user : null);
        }
    }
}
