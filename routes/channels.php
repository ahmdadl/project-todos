<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Vinkla\Hashids\Facades\Hashids;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('todos.{projectId}', function (User $user, int $projectId) {
    return $user->can('teamMember', Project::find($projectId))
        ? [
            'name' => $user->name,
            'id' => Hashids::encode($user->id),
            'image' => $user->profile_photo_url,
        ]
        : null;
});
