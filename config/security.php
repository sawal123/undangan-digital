<?php

return [
    'login_failed_max_per_email_ip' => (int) env('LOGIN_FAILED_MAX_PER_EMAIL_IP', 5),
    'login_failed_decay_seconds' => (int) env('LOGIN_FAILED_DECAY_SECONDS', 60),
    'login_attempts_per_ip' => (int) env('LOGIN_ATTEMPTS_PER_IP', 20),
    'login_attempts_decay_seconds' => (int) env('LOGIN_ATTEMPTS_DECAY_SECONDS', 900),

    'register_per_ip_hour' => (int) env('REGISTER_PER_IP_HOUR', 3),
    'register_per_ip_day' => (int) env('REGISTER_PER_IP_DAY', 10),

    'turnstile' => [
        'enabled' => (bool) env('TURNSTILE_ENABLED', false),
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

    'block_disposable_email' => (bool) env('BLOCK_DISPOSABLE_EMAIL', false),
    'disposable_domains' => array_filter(array_map(
        fn ($domain) => strtolower(trim($domain)),
        explode(',', (string) env('DISPOSABLE_EMAIL_DOMAINS', 'mailinator.com,10minutemail.com,tempmail.com'))
    )),

    'security_alert_email_enabled' => (bool) env('SECURITY_ALERT_EMAIL_ENABLED', false),
    'security_alert_email' => env('SECURITY_ALERT_EMAIL'),
    'security_alert_cooldown_minutes' => (int) env('SECURITY_ALERT_COOLDOWN_MINUTES', 30),

    'auth_log_retention_days' => (int) env('AUTH_LOG_RETENTION_DAYS', 90),
    'auth_high_risk_retention_days' => (int) env('AUTH_HIGH_RISK_RETENTION_DAYS', 365),
];
