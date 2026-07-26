<?php

namespace App\Livewire\AdminDemo;

use App\Models\AuthActivityLog;
use App\Models\User;
use App\Services\AuthActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserDemo extends Component
{
    use WithPagination;

    public $search = '';

    public $user_id;

    public $name;

    public $email;

    public $phone;

    public $role;

    public $password;

    public $securityReason = '';

    public $isEdit = false;

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            })
            ->withCount(['authActivityLogs as failed_logins_24h_count' => function ($query) {
                $query->where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)
                    ->where('occurred_at', '>=', now()->subDay());
            }])
            ->latest()
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.admin-demo.user-demo', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = '';
        $this->password = '';
        $this->securityReason = '';
        $this->user_id = null;
        $this->isEdit = false;
    }

    public function create()
    {
        $this->resetInput();
        $this->isEdit = false;
        $this->dispatch('open-modal', name: 'user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->getRoleNames()->first() ?? '';
        $this->password = '';
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'user-modal');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.($this->user_id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
        ];

        if (! $this->isEdit) {
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        $this->validate($rules);

        if ($this->isEdit) {
            $user = User::findOrFail($this->user_id);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ];
            if (! empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }
            $user->update($data);

            if (! empty($this->role)) {
                $user->syncRoles([$this->role]);
            }

            session()->flash('message', 'User successfully updated.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => bcrypt($this->password),
                'avatar' => 'images/default-avatar.png',
                'google_id' => 'NULL',
                'is_active' => false,
            ]);

            if (! empty($this->role)) {
                $user->assignRole($this->role);
            }

            session()->flash('message', 'User successfully created.');
        }

        $this->resetInput();
        $this->dispatch('close-modal', name: 'user-modal');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User successfully deleted.');
    }

    public function suspend($id, ?string $reason = null)
    {
        $reason = trim((string) ($reason ?: $this->securityReason));
        $this->validate(['securityReason' => 'nullable|string|max:500']);

        if ($reason === '') {
            $this->addError('securityReason', 'Alasan wajib diisi.');

            return;
        }

        $user = User::findOrFail($id);

        $user->forceFill([
            'suspended_at' => now(),
            'suspension_reason' => $reason,
            'suspended_by' => auth()->id(),
        ])->save();

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_ACCOUNT_SUSPENDED,
            user: $user,
            metadata: ['admin_id' => auth()->id(), 'target_user_id' => $user->id, 'reason' => $reason],
            riskLevel: AuthActivityLog::RISK_HIGH,
            riskReasons: ['akun ditangguhkan oleh admin']
        );

        $this->securityReason = '';
        session()->flash('message', 'Akun berhasil ditangguhkan.');
    }

    public function reactivate($id, ?string $reason = null)
    {
        $user = User::findOrFail($id);
        $reason = trim((string) ($reason ?: $this->securityReason ?: 'reactivated_by_admin'));

        $user->forceFill([
            'suspended_at' => null,
            'suspension_reason' => null,
            'suspended_by' => null,
            'security_risk_level' => AuthActivityLog::RISK_LOW,
        ])->save();

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_ACCOUNT_REACTIVATED,
            user: $user,
            metadata: ['admin_id' => auth()->id(), 'target_user_id' => $user->id, 'reason' => $reason]
        );

        $this->securityReason = '';
        session()->flash('message', 'Akun berhasil diaktifkan kembali.');
    }

    public function revokeSessions($id, ?string $reason = null)
    {
        $user = User::findOrFail($id);
        $reason = trim((string) ($reason ?: $this->securityReason ?: 'revoked_by_admin'));

        DB::transaction(function () use ($user) {
            $user->forceFill(['remember_token' => Str::random(60)])->save();

            if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->delete();
            }
        });

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_RATE_LIMIT_TRIGGERED,
            'session_revoked',
            $user,
            metadata: ['admin_id' => auth()->id(), 'target_user_id' => $user->id, 'reason' => $reason]
        );

        $this->securityReason = '';
        session()->flash('message', 'Sesi user berhasil dicabut.');
    }

    public function resendVerification($id)
    {
        $user = User::findOrFail($id);

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        session()->flash('message', 'Email verifikasi diproses.');
    }

    public function forcePasswordReset($id)
    {
        $user = User::findOrFail($id);
        Password::sendResetLink(['email' => $user->email]);

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_PASSWORD_RESET_REQUESTED,
            'forced_by_admin',
            $user,
            metadata: ['admin_id' => auth()->id(), 'target_user_id' => $user->id]
        );

        session()->flash('message', 'Link reset password diproses.');
    }
}
