<?php

namespace App\Policies;

use App\User;
use App\Event;
use App\EventAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function read(User $user, Event $event)
    {
        return $user->id == $event->user_id || $event->accessUsers()->exists();
    }

    public function edit(User $user, Event $event)
    {
        return $user->id == $event->user_id || $event->accessUsers()->where('type', '=', EventAccess::ACCESS_EDIT)->exists();
    }

    public function finish(User $user, Event $event)
    {
        return is_null($event->finished_at) && $this->accessEdit($user, $event);
    }

    public function accessEdit(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}
