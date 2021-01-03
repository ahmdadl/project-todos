<?php

use App\Http\Controllers\GetCategoryList;
use App\Http\Livewire\AddTodo;
use App\Http\Livewire\Counter;
use App\Http\Livewire\GetProjectList;
use App\Http\Livewire\GetTodoList;
use App\Http\Livewire\TodoList;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// $p = Project::factory()
//     ->count(5)
//     ->sequence(['user_id' => 1])
//     ->create();
// $user = User::whereEmail('user@site.test')->first();
// $p->each(fn(Project $project) => $project->team()->sync($user));

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])
//     ->get('/dashboard', function () {
//         return view('dashboard');
//     })
//     ->name('dashboard');

Route::group(
    [
        'prefix' => '/categories',
        'middleware' => ['auth:sanctum', 'can:is_admin'],
    ],
    function () {
        Route::get('', GetCategoryList::class);
    }
);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/projects')->group(function () {
        Route::get('', GetProjectList::class);
        Route::prefix('/{project}/{todos?}')
            ->where([
                'project' => '[a-z0-9]+(?:-[a-z0-9]+)*',
            ])
            ->group(function () {
                Route::get('', GetTodoList::class);
                Route::post('', AddTodo::class);
            });
    });
});
