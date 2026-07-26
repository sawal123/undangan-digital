<?php

namespace App\Policies;

use App\Models\Data;
use App\Models\User;

class DataPolicy
{
    public function view(User $user, Data $data): bool
    {
        return (int) $data->user_id === (int) $user->id;
    }

    public function update(User $user, Data $data): bool
    {
        return $this->view($user, $data);
    }

    public function delete(User $user, Data $data): bool
    {
        return $this->view($user, $data);
    }
}
