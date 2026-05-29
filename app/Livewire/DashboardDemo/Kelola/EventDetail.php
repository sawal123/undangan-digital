<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use App\Models\KelolaUndangan\EventDetail as EventDetailModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventDetail extends Component
{
    use WithFileUploads;

    public $dataId;
    public $eventTypeName = 'Event';
    public $headline;
    public $host_name;
    public $speaker_name;
    public $dress_code;
    public $description;
    public $image;

    protected $rules = [
        'headline' => 'nullable|string|max:255',
        'host_name' => 'nullable|string|max:255',
        'speaker_name' => 'nullable|string|max:255',
        'dress_code' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:1000',
        'image' => 'nullable',
    ];

    public function mount($id)
    {
        $data = Data::with('eventType')->where('uid', $id)->firstOrFail();

        $this->dataId = $data->id;
        $this->eventTypeName = $data->eventType?->name ?? 'Event';
        $this->loadDetail();
    }

    public function loadDetail()
    {
        $detail = EventDetailModel::where('data_id', $this->dataId)->first();

        if (! $detail) {
            return;
        }

        $this->headline = $detail->headline;
        $this->host_name = $detail->host_name;
        $this->speaker_name = $detail->speaker_name;
        $this->dress_code = $detail->dress_code;
        $this->description = $detail->description;
        $this->image = $detail->image ? asset('storage/' . $detail->image) : null;
    }

    public function save()
    {
        $this->validate();

        $detail = EventDetailModel::where('data_id', $this->dataId)->first();
        $imagePath = is_object($this->image) ? $this->image->store('event-detail', 'public') : null;

        if ($detail && $imagePath && $detail->image && Storage::disk('public')->exists($detail->image)) {
            Storage::disk('public')->delete($detail->image);
        }

        $data = [
            'data_id' => $this->dataId,
            'headline' => $this->headline,
            'host_name' => $this->host_name,
            'speaker_name' => $this->speaker_name,
            'dress_code' => $this->dress_code,
            'description' => $this->description,
        ];

        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        EventDetailModel::updateOrCreate(
            ['data_id' => $this->dataId],
            $data
        );

        session()->flash('message', 'Detail event berhasil disimpan.');
        $this->loadDetail();
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.event-detail')->layout('components.layouts.user-new', [
            'headerTitle' => 'Detail ' . $this->eventTypeName,
        ]);
    }
}
