<?php

namespace App\Livewire\AdminDemo;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettingDemo extends Component
{
    use WithFileUploads;

    public ?int $setting_id = null;

    // Identitas Website
    public string $app_name = '';

    public $logo;

    public ?string $old_logo = null;

    public $logo_dark;

    public ?string $old_logo_dark = null;

    public $favicon;

    public ?string $old_favicon = null;

    public $apple_touch_icon;

    public ?string $old_apple_touch_icon = null;

    // SEO Dasar
    public ?string $seo_title = null;

    public ?string $seo_description = null;

    public ?string $seo_keywords = null;

    public ?string $seo_author = null;

    public ?string $google_site_verification = null;

    // Search Engine Robots
    public bool $seo_robots_index = true;

    public bool $seo_robots_follow = true;

    // Social Sharing
    public ?string $og_title = null;

    public ?string $og_description = null;

    public $og_image;

    public ?string $old_og_image = null;

    public ?string $twitter_title = null;

    public ?string $twitter_description = null;

    public $twitter_image;

    public ?string $old_twitter_image = null;

    public string $twitter_card = 'summary_large_image';

    // Informasi Kontak
    public ?string $whatsapp = null;

    public ?string $email = null;

    public ?string $address = null;

    public ?string $instagram = null;

    public ?string $facebook = null;

    public ?string $tiktok = null;

    public function mount(): void
    {
        $setting = SystemSetting::current();

        $this->setting_id = $setting->id;
        $this->app_name = $setting->app_name ?: 'WayaeNikah';
        $this->old_logo = $setting->logo;
        $this->old_logo_dark = $setting->logo_dark;
        $this->old_favicon = $setting->favicon;
        $this->old_apple_touch_icon = $setting->apple_touch_icon;

        $this->seo_title = $setting->seo_title;
        $this->seo_description = $setting->seo_description;
        $this->seo_keywords = $setting->seo_keywords;
        $this->seo_author = $setting->seo_author;
        $this->google_site_verification = $setting->google_site_verification;

        $this->seo_robots_index = (bool) ($setting->seo_robots_index ?? true);
        $this->seo_robots_follow = (bool) ($setting->seo_robots_follow ?? true);

        $this->og_title = $setting->og_title;
        $this->og_description = $setting->og_description;
        $this->old_og_image = $setting->og_image;

        $this->twitter_title = $setting->twitter_title;
        $this->twitter_description = $setting->twitter_description;
        $this->old_twitter_image = $setting->twitter_image;
        $this->twitter_card = $setting->twitter_card ?: 'summary_large_image';

        $this->whatsapp = $setting->whatsapp;
        $this->email = $setting->email;
        $this->address = $setting->address;
        $this->instagram = $setting->instagram;
        $this->facebook = $setting->facebook;
        $this->tiktok = $setting->tiktok;
    }

    public function render()
    {
        $setting = SystemSetting::current();

        return view('livewire.admin-demo.system-setting-demo', [
            'setting' => $setting,
        ])->layout('components.layouts.admin-new');
    }

    public function save(): void
    {
        $this->validate([
            'app_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,svg,webp|max:1024',
            'apple_touch_icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'seo_author' => 'nullable|string|max:255',
            'google_site_verification' => 'nullable|string|max:255',
            'seo_robots_index' => 'boolean',
            'seo_robots_follow' => 'boolean',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'twitter_card' => 'required|string|in:summary,summary_large_image',
            'whatsapp' => 'nullable|string|max:30|regex:/^[0-9+\-\s()]+$/',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
        ]);

        $setting = SystemSetting::findOrFail($this->setting_id);

        $newFilesToDeleteOnFailure = [];
        $oldFilesToDeleteOnSuccess = [];

        $data = [
            'app_name' => $this->app_name,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'seo_author' => $this->seo_author,
            'google_site_verification' => $this->google_site_verification,
            'seo_robots_index' => $this->seo_robots_index,
            'seo_robots_follow' => $this->seo_robots_follow,
            'og_title' => $this->og_title,
            'og_description' => $this->og_description,
            'twitter_title' => $this->twitter_title,
            'twitter_description' => $this->twitter_description,
            'twitter_card' => $this->twitter_card,
            'whatsapp' => trim((string) $this->whatsapp) ?: null,
            'email' => trim((string) $this->email) ?: null,
            'address' => trim((string) $this->address) ?: null,
            'instagram' => trim((string) $this->instagram) ?: null,
            'facebook' => trim((string) $this->facebook) ?: null,
            'tiktok' => trim((string) $this->tiktok) ?: null,
        ];

        // Handle file uploads safely
        if ($this->logo) {
            $newPath = $this->logo->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->logo) {
                $oldFilesToDeleteOnSuccess[] = $setting->logo;
            }
            $data['logo'] = $newPath;
        }

        if ($this->logo_dark) {
            $newPath = $this->logo_dark->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->logo_dark) {
                $oldFilesToDeleteOnSuccess[] = $setting->logo_dark;
            }
            $data['logo_dark'] = $newPath;
        }

        if ($this->favicon) {
            $newPath = $this->favicon->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->favicon) {
                $oldFilesToDeleteOnSuccess[] = $setting->favicon;
            }
            $data['favicon'] = $newPath;
        }

        if ($this->apple_touch_icon) {
            $newPath = $this->apple_touch_icon->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->apple_touch_icon) {
                $oldFilesToDeleteOnSuccess[] = $setting->apple_touch_icon;
            }
            $data['apple_touch_icon'] = $newPath;
        }

        if ($this->og_image) {
            $newPath = $this->og_image->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->og_image) {
                $oldFilesToDeleteOnSuccess[] = $setting->og_image;
            }
            $data['og_image'] = $newPath;
        }

        if ($this->twitter_image) {
            $newPath = $this->twitter_image->store('settings', 'public');
            $newFilesToDeleteOnFailure[] = $newPath;
            if ($setting->twitter_image) {
                $oldFilesToDeleteOnSuccess[] = $setting->twitter_image;
            }
            $data['twitter_image'] = $newPath;
        }

        try {
            DB::transaction(function () use ($setting, $data) {
                $setting->update($data);
            });

            // Delete old files only after DB update succeeds
            foreach ($oldFilesToDeleteOnSuccess as $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            Cache::forget('system_settings.main');

            $this->mount();
            $this->logo = null;
            $this->logo_dark = null;
            $this->favicon = null;
            $this->apple_touch_icon = null;
            $this->og_image = null;
            $this->twitter_image = null;

            session()->flash('message', 'Pengaturan sistem berhasil diperbarui.');
        } catch (\Throwable $e) {
            // Delete new files on failure
            foreach ($newFilesToDeleteOnFailure as $newFile) {
                Storage::disk('public')->delete($newFile);
            }

            session()->flash('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    public function deleteImage(string $field): void
    {
        $setting = SystemSetting::findOrFail($this->setting_id);
        $allowedFields = ['logo', 'logo_dark', 'favicon', 'apple_touch_icon', 'og_image', 'twitter_image'];

        if (!in_array($field, $allowedFields, true)) {
            return;
        }

        $oldPath = $setting->{$field};
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
            $setting->update([$field => null]);
            Cache::forget('system_settings.main');
            $this->mount();
            session()->flash('message', 'Gambar berhasil dihapus.');
        }
    }
}
