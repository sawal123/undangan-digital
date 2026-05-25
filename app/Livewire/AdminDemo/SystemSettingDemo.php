<?php

namespace App\Livewire\AdminDemo;

use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SystemSettingDemo extends Component
{
    use WithFileUploads;

    public $setting_id;
    public $app_name;
    public $logo;
    public $old_logo;
    public $favicon;
    public $old_favicon;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;

    public function mount()
    {
        $setting = SystemSetting::first();
        if (!$setting) {
            $setting = SystemSetting::create([
                'app_name' => 'AdminPanel Pro',
            ]);
        }

        $this->setting_id = $setting->id;
        $this->app_name = $setting->app_name;
        $this->old_logo = $setting->logo;
        $this->old_favicon = $setting->favicon;
        $this->seo_title = $setting->seo_title;
        $this->seo_keywords = $setting->seo_keywords;
        $this->seo_description = $setting->seo_description;
    }

    public function render()
    {
        return view('livewire.admin-demo.system-setting-demo')->layout('components.layouts.admin-new');
    }

    public function save()
    {
        $this->validate([
            'app_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string',
            'seo_description' => 'nullable|string',
        ]);

        $setting = SystemSetting::findOrFail($this->setting_id);
        $data = [
            'app_name' => $this->app_name,
            'seo_title' => $this->seo_title,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
        ];

        if ($this->logo) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $this->logo->store('settings', 'public');
            $this->old_logo = $data['logo'];
        }

        if ($this->favicon) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $this->favicon->store('settings', 'public');
            $this->old_favicon = $data['favicon'];
        }

        $setting->update($data);

        // Reset file inputs
        $this->logo = null;
        $this->favicon = null;

        session()->flash('message', 'Pengaturan sistem berhasil disimpan.');
    }
}
