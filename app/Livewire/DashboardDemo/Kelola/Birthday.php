<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\BirthdayProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Birthday extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public $dataId;

    public $name;

    public $nickname;

    public $age;

    public $parent_name;

    public $description;

    public $photo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'nickname' => 'nullable|string|max:255',
        'age' => 'nullable|integer|min:1|max:150',
        'parent_name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:1000',
        'photo' => 'nullable',
    ];

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->loadProfile();
    }

    public function loadProfile(): void
    {
        $this->authorizeInvitationState();
        $profile = BirthdayProfile::where('data_id', $this->dataId)->first();

        if (! $profile) {
            return;
        }

        $this->name = $profile->name;
        $this->nickname = $profile->nickname;
        $this->age = $profile->age;
        $this->parent_name = $profile->parent_name;
        $this->description = $profile->description;
        $this->photo = $profile->photo ? asset('storage/'.$profile->photo) : null;
    }

    public function save(): void
    {
        $this->authorizeInvitationState();
        $this->validate();
        if (is_object($this->photo)) {
            $this->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
        }

        $profile = BirthdayProfile::where('data_id', $this->dataId)->first();
        $photoPath = is_object($this->photo) ? $this->photo->store('birthday', 'public') : null;

        if ($profile && $photoPath && $profile->photo && Storage::disk('public')->exists($profile->photo)) {
            Storage::disk('public')->delete($profile->photo);
        }

        $data = [
            'data_id' => $this->dataId,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'age' => $this->age,
            'parent_name' => $this->parent_name,
            'description' => $this->description,
        ];

        if ($photoPath) {
            $data['photo'] = $photoPath;
        }

        BirthdayProfile::updateOrCreate(
            ['data_id' => $this->dataId],
            $data
        );

        session()->flash('message', 'Profil ulang tahun berhasil disimpan.');
        $this->loadProfile();
    }

    public function render(): View
    {
        $this->authorizeInvitationState();

        return view('livewire.dashboard.kelola.birthday')->layout('components.layouts.user-new', [
            'headerTitle' => 'Profil Ulang Tahun',
        ]);
    }
}
