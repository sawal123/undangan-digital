<?php

namespace App\Livewire\DashboardDemo\Kelola\Concerns;

use App\Models\Data;

trait LoadsOwnedInvitation
{
    protected function ownedInvitationByUid(string $uid, array $with = []): Data
    {
        return Data::query()
            ->with($with)
            ->forUid($uid)
            ->ownedBy(auth()->id())
            ->firstOrFail();
    }

    protected function ownedInvitationById(int $id, array $with = []): Data
    {
        return Data::query()
            ->with($with)
            ->ownedBy(auth()->id())
            ->findOrFail($id);
    }
}
