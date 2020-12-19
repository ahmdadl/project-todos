<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

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
Broadcast::channel('projects.{project}', function (
    User $user,
    Project $project
) {
    return $user->can('teamMember', $project);
});

Broadcast::channel('todos.{categoryId}', function (
    User $user,
    int $categoryId
) {
    return $user->only('id', 'name');
});
