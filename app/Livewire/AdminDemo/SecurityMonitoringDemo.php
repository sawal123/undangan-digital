<?php

namespace App\Livewire\AdminDemo;

use App\Models\AuthActivityLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SecurityMonitoringDemo extends Component
{
    use WithPagination;

    public string $eventType = '';

    public string $riskLevel = '';

    public string $status = '';

    public string $email = '';

    public string $ip = '';

    public string $accountStatus = '';

    public string $date = '';

    public function render()
    {
        $logs = AuthActivityLog::query()
            ->with('user')
            ->when($this->eventType, fn ($query) => $query->where('event_type', $this->eventType))
            ->when($this->riskLevel, fn ($query) => $query->where('risk_level', $this->riskLevel))
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->email, fn ($query) => $query->where('email', 'like', '%'.$this->email.'%'))
            ->when($this->ip, fn ($query) => $query->where('ip_address', 'like', '%'.$this->ip.'%'))
            ->when($this->date, fn ($query) => $query->whereDate('occurred_at', $this->date))
            ->when($this->accountStatus === 'verified', fn ($query) => $query->whereHas('user', fn ($user) => $user->whereNotNull('email_verified_at')))
            ->when($this->accountStatus === 'unverified', fn ($query) => $query->whereHas('user', fn ($user) => $user->whereNull('email_verified_at')))
            ->when($this->accountStatus === 'suspended', fn ($query) => $query->whereHas('user', fn ($user) => $user->whereNotNull('suspended_at')))
            ->latest('occurred_at')
            ->paginate(15);

        $today = now()->toDateString();

        $summary = [
            'login_success_today' => AuthActivityLog::where('event_type', AuthActivityLog::EVENT_LOGIN_SUCCESS)->whereDate('occurred_at', $today)->count(),
            'login_failed_today' => AuthActivityLog::where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)->whereDate('occurred_at', $today)->count(),
            'register_today' => AuthActivityLog::where('event_type', AuthActivityLog::EVENT_REGISTER)->whereDate('occurred_at', $today)->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'rate_limited_ips' => AuthActivityLog::where('event_type', AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED)->whereDate('occurred_at', $today)->distinct()->count('ip_address'),
            'high_risk' => AuthActivityLog::whereIn('risk_level', [AuthActivityLog::RISK_HIGH, AuthActivityLog::RISK_CRITICAL])->whereDate('occurred_at', $today)->count(),
        ];

        return view('livewire.admin-demo.security-monitoring-demo', [
            'logs' => $logs,
            'summary' => $summary,
            'eventTypes' => [
                AuthActivityLog::EVENT_REGISTER,
                AuthActivityLog::EVENT_LOGIN_SUCCESS,
                AuthActivityLog::EVENT_LOGIN_FAILED,
                AuthActivityLog::EVENT_LOGOUT,
                AuthActivityLog::EVENT_EMAIL_VERIFIED,
                AuthActivityLog::EVENT_PASSWORD_RESET_REQUESTED,
                AuthActivityLog::EVENT_PASSWORD_RESET_COMPLETED,
                AuthActivityLog::EVENT_PASSWORD_CHANGED,
                AuthActivityLog::EVENT_EMAIL_CHANGED,
                AuthActivityLog::EVENT_ACCOUNT_SUSPENDED,
                AuthActivityLog::EVENT_ACCOUNT_REACTIVATED,
                AuthActivityLog::EVENT_ADMIN_ACCESS_DENIED,
                AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
                AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
            ],
        ])->layout('components.layouts.admin-new');
    }

    public function resetFilters(): void
    {
        $this->reset(['eventType', 'riskLevel', 'status', 'email', 'ip', 'accountStatus', 'date']);
        $this->resetPage();
    }
}
