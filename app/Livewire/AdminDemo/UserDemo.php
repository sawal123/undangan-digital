<?php

namespace App\Livewire\AdminDemo;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserDemo extends Component
{
    use WithPagination;

    public $search = '';
    public $user_id, $name, $email, $phone;
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

        return view('livewire.admin-demo.user-demo', [
            'users' => $users,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->user_id = null;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'user-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'User successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'user-modal');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User successfully deleted.');
    }
}
