<?php

namespace App\Livewire\DashboardDemo\Kelola\Concerns;

use App\Models\AuthActivityLog;
use App\Models\Data;
use App\Services\AuthActivityLogger;

trait LoadsOwnedInvitation
{
    protected function ownedInvitationByUid(string $uid, array $with = []): Data
    {
        $data = Data::query()
            ->with($with)
            ->forUid($uid)
            ->ownedBy(auth()->id())
            ->first();

        if (! $data) {
            $this->logOwnershipViolationForUid($uid);
            abort(404);
        }

        return $data;
    }

    protected function ownedInvitationById(int $id, array $with = []): Data
    {
        $data = Data::query()
            ->with($with)
            ->ownedBy(auth()->id())
            ->find($id);

        if (! $data) {
            $this->logOwnershipViolationForId($id);
            abort(404);
        }

        return $data;
    }

    protected function authorizeInvitationState(array $with = []): Data
    {
        return $this->ownedInvitationById((int) $this->dataId, $with);
    }

    protected function logOwnershipViolationForUid(string $uid): void
    {
        $target = Data::query()->where('uid', $uid)->first();

        if ($target && (int) $target->user_id !== (int) auth()->id()) {
            app(AuthActivityLogger::class)->log(
                AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
                'denied',
                auth()->user(),
                metadata: [
                    'target_resource_type' => 'data',
                    'target_resource_id' => $target->id,
                    'route' => optional(request()->route())->getName(),
                ],
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['user mencoba mengakses undangan milik pengguna lain']
            );
        }
    }

    protected function logOwnershipViolationForId(int $id): void
    {
        $target = Data::query()->find($id);

        if ($target && (int) $target->user_id !== (int) auth()->id()) {
            app(AuthActivityLogger::class)->log(
                AuthActivityLog::EVENT_OWNERSHIP_VIOLATION,
                'denied',
                auth()->user(),
                metadata: [
                    'target_resource_type' => 'data',
                    'target_resource_id' => $target->id,
                    'route' => optional(request()->route())->getName(),
                ],
                riskLevel: AuthActivityLog::RISK_HIGH,
                riskReasons: ['user mencoba mengakses undangan milik pengguna lain']
            );
        }
    }
}
