<?php

namespace App\Services;

use App\Models\Data;
use App\Models\KelolaUndangan\Tamu;

class InvitationMessageRenderer
{
    public function render(Data $data, Tamu $tamu, ?string $template = null): string
    {
        $template = $template ?: 'Kepada {{tamu}}, silakan buka undangan berikut: {{link}}';
        $eventKey = $data->eventType?->key;

        $replacements = [
            '{{tamu}}' => $tamu->nama,
            '{{link}}' => url('/u/'.$data->slug.'/'.$tamu->kode),
            '{{nama_mempelai1}}' => $data->wanita?->nama_panggilan ?? '',
            '{{nama_mempelai2}}' => $data->pria?->nama_panggilan ?? '',
            '{{nama_ulang_tahun}}' => $data->birthdayProfile?->name ?? '',
            '{{usia}}' => (string) ($data->birthdayProfile?->age ?? ''),
            '{{nama_event}}' => match ($eventKey) {
                'birthday' => $data->birthdayProfile?->name,
                default => $data->eventDetail?->headline ?? $data->title,
            } ?? '',
            '{{penyelenggara}}' => $data->eventDetail?->host_name ?? $data->birthdayProfile?->parent_name ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }
}
