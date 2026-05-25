<?php

namespace App\Livewire\AdminDemo;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserDemo extends Component
{
    use WithPagination;

    public $search = '';
    public $user_id, $name, $email, $phone, $role, $password;
    public $isEdit = false;

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            })
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
            'email' => 'required|email|unique:users,email,' . ($this->user_id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
        ];

        if (!$this->isEdit) {
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
            if (!empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }
            $user->update($data);

            if (!empty($this->role)) {
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

            if (!empty($this->role)) {
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
}
