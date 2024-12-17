<?php

namespace App\Policies;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DatabaseNotification $databaseNotification): bool
    {
        #                                           table column
        return $user->id === $databaseNotification->notifiable_id;
    }
}