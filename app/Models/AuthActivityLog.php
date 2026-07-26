<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthActivityLog extends Model
{
    use HasFactory;

    public const EVENT_REGISTER = 'register';

    public const EVENT_LOGIN_SUCCESS = 'login_success';

    public const EVENT_LOGIN_FAILED = 'login_failed';

    public const EVENT_LOGOUT = 'logout';

    public const EVENT_EMAIL_VERIFIED = 'email_verified';

    public const EVENT_PASSWORD_RESET_REQUESTED = 'password_reset_requested';

    public const EVENT_PASSWORD_RESET_COMPLETED = 'password_reset_completed';

    public const EVENT_PASSWORD_CHANGED = 'password_changed';

    public const EVENT_EMAIL_CHANGED = 'email_changed';

    public const EVENT_ACCOUNT_SUSPENDED = 'account_suspended';

    public const EVENT_ACCOUNT_REACTIVATED = 'account_reactivated';

    public const EVENT_ADMIN_ACCESS_DENIED = 'admin_access_denied';

    public const EVENT_OWNERSHIP_VIOLATION = 'ownership_violation';

    public const EVENT_RATE_LIMIT_TRIGGERED = 'rate_limit_triggered';

    public const RISK_LOW = 'low';

    public const RISK_MEDIUM = 'medium';

    public const RISK_HIGH = 'high';

    public const RISK_CRITICAL = 'critical';

    protected $fillable = [
        'user_id',
        'email',
        'event_type',
        'status',
        'ip_address',
        'user_agent',
        'session_id',
        'request_path',
        'request_method',
        'risk_level',
        'risk_reasons',
        'metadata',
        'occurred_at',
    ];

    protected $casts = [
        'risk_reasons' => 'array',
        'metadata' => 'array',
        'occurred_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
