<?php

namespace App\Livewire\AdminDemo;

use App\Models\AuthActivityLog;
use App\Models\User;
use App\Services\AuthActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $user_id = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $role = '';

    public string $password = '';

    public string $securityReason = '';

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm);
                });
            })
            ->withCount(['authActivityLogs as failed_logins_24h_count' => function ($query) {
                $query->where('event_type', AuthActivityLog::EVENT_LOGIN_FAILED)
                    ->where('occurred_at', '>=', now()->subDay());
            }])
            ->latest('id')
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.admin-demo.user-demo', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = '';
        $this->password = '';
        $this->securityReason = '';
        $this->user_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->resetInput();
        $this->isEdit = false;
        $this->dispatch('open-modal', name: 'user-modal');
    }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->getRoleNames()->first() ?? '';
        $this->password = '';
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'user-modal');
    }

    public function store(): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|exists:roles,name',
        ];

        if (!$this->isEdit) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8';
        }

        $this->validate($rules);

        if ($this->isEdit) {
            $user = User::findOrFail($this->user_id);

            // Protection: Prevent demoting the last Owner
            $currentRole = $user->getRoleNames()->first();
            if ($currentRole === 'Owner' && $this->role !== 'Owner') {
                $ownerCount = User::role('Owner')->count();
                if ($ownerCount <= 1) {
                    session()->flash('error', 'Tidak dapat mengubah role Owner terakhir di sistem.');
                    return;
                }
            }

            DB::transaction(function () use ($user) {
                $data = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ];

                if (!empty($this->password)) {
                    $data['password'] = Hash::make($this->password);
                }

                $user->update($data);

                if (!empty($this->role)) {
                    $user->syncRoles([$this->role]);
                }
            });

            app(AuthActivityLogger::class)->log(
                AuthActivityLog::EVENT_EMAIL_CHANGED,
                user: $user,
                metadata: ['admin_id' => Auth::id(), 'action' => 'user_updated', 'role' => $this->role]
            );

            session()->flash('message', 'Pengguna berhasil diperbarui.');
        } else {
            DB::transaction(function () {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'password' => Hash::make($this->password),
                    'avatar' => 'images/default-avatar.png',
                    'google_id' => null,
                    'is_active' => true,
                ]);

                if (!empty($this->role)) {
                    $user->assignRole($this->role);
                }

                app(AuthActivityLogger::class)->log(
                    AuthActivityLog::EVENT_LOGIN_SUCCESS,
                    user: $user,
                    metadata: ['admin_id' => Auth::id(), 'action' => 'user_created', 'role' => $this->role]
                );
            });

            session()->flash('message', 'Pengguna baru berhasil dibuat.');
        }

        $this->resetInput();
        $this->dispatch('close-modal', name: 'user-modal');
    }

    public function delete(int $id): void
    {
        // Protection: Prevent self deletion
        if ($id === Auth::id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $user = User::findOrFail($id);

        // Protection: Prevent deleting the last Owner
        if ($user->hasRole('Owner')) {
            $ownerCount = User::role('Owner')->count();
            if ($ownerCount <= 1) {
                session()->flash('error', 'Tidak dapat menghapus Owner terakhir di sistem.');
                return;
            }
        }

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_ACCOUNT_SUSPENDED,
            user: $user,
            metadata: ['admin_id' => Auth::id(), 'action' => 'user_deleted']
        );

        $user->delete();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function suspend(int $id, ?string $reason = null): void
    {
        // Protection: Prevent self suspension
        if ($id === Auth::id()) {
            session()->flash('error', 'Anda tidak dapat menangguhkan akun Anda sendiri.');
            return;
        }

        $reason = trim((string) ($reason ?: $this->securityReason));
        $this->validate(['securityReason' => 'nullable|string|max:500']);

        if ($reason === '') {
            $this->addError('securityReason', 'Alasan penangguhan wajib diisi.');
            return;
        }

        $user = User::findOrFail($id);

        // Protection: Prevent suspending last Owner
        if ($user->hasRole('Owner')) {
            $activeOwnerCount = User::role('Owner')->whereNull('suspended_at')->count();
            if ($activeOwnerCount <= 1) {
                session()->flash('error', 'Tidak dapat menangguhkan Owner aktif terakhir di sistem.');
                return;
            }
        }

        $user->forceFill([
            'suspended_at' => now(),
            'suspension_reason' => $reason,
            'suspended_by' => Auth::id(),
        ])->save();

        app(AuthActivityLogger::class)->log(
            AuthActivityLog::EVENT_ACCOUNT_SUSPENDED,
            user: $user,
            metadata: ['admin_id' => Auth::id(), 'target_user_id' => $user->id, 'reason' => $reason],
            riskLevel: AuthActivityLog::RISK_HIGH,
            riskReasons: ['akun ditangguhkan oleh admin']
        );

        $this->securityReason = '';
        session()->flash('message', 'Akun berhasil ditangguhkan.');
    }

    public function reactivate(int $id, ?string $reason = null): void
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
            metadata: ['admin_id' => Auth::id(), 'target_user_id' => $user->id, 'reason' => $reason]
        );

        $this->securityReason = '';
        session()->flash('message', 'Akun berhasil diaktifkan kembali.');
    }

    public function revokeSessions(int $id, ?string $reason = null): void
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
            metadata: ['admin_id' => Auth::id(), 'target_user_id' => $user->id, 'reason' => $reason]
        );

        $this->securityReason = '';
        session()->flash('message', 'Sesi pengguna berhasil dicabut.');
    }

    public function resendVerification(int $id): void
    {
        $user = User::findOrFail($id);

        try {
            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                session()->flash('message', 'Email verifikasi berhasil dikirim ke ' . $user->email);
            } else {
                session()->flash('message', 'Email pengguna sudah terverifikasi.');
            }
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage());
        }
    }

    public function forcePasswordReset(int $id): void
    {
        $user = User::findOrFail($id);

        try {
            Password::sendResetLink(['email' => $user->email]);

            app(AuthActivityLogger::class)->log(
                AuthActivityLog::EVENT_PASSWORD_RESET_REQUESTED,
                'forced_by_admin',
                $user,
                metadata: ['admin_id' => Auth::id(), 'target_user_id' => $user->id]
            );

            session()->flash('message', 'Link reset password berhasil dikirim ke ' . $user->email);
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal mengirim link reset password: ' . $e->getMessage());
        }
    }
}
