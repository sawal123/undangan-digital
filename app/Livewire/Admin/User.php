<?php

namespace App\Livewire\Admin;

use App\Models\User as ModelsUser;
use Livewire\Component;

class User extends Component
{
    public $user;
    public $idUser;
    public $isModalOpenUser = false;
    public $name, $email, $phone;
    public function editUser($id)
    {
        $this->idUser = $id;
        $this->isModalOpenUser = true;
        $user = ModelsUser::find($id);
        // dd($user);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }
    public function updateUser()
    {
        $user = ModelsUser::find($this->idUser);
        // dd($user);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        $user->save();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('success', 'User berhasil diUpdate!');
        $this->mount();
    }
    public function closeModal()
    {
        $this->isModalOpenUser = false;
        $this->modalDelete = false;
    }
    public $modalDelete = false;
    public function confirmDel($id)
    {
        $this->idUser = $id;
        $this->modalDelete = true;
    }
    public function delUser($id)
    {
        $user = ModelsUser::find($id);
        $user->delete();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('success', 'User berhasil diDelete!');
        $this->mount();
    }
    public function mount()
    {
        $this->user = ModelsUser::all();
    }
    public function render()
    {
        return view('livewire.admin.user');
    }
}
