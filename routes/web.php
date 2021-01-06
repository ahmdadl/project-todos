<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Category\Index;
use App\Http\Livewire\Category\Show;
use App\Http\Livewire\Project\Index as ProjectIndex;
use App\Http\Livewire\Todo\Create;
use App\Http\Livewire\Todo\Index as TodoIndex;
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

Route::get('/', HomeController::class);

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
        Route::get('', Index::class);
        Route::get('/{category}', Show::class);
    }
);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/projects')->group(function () {
        Route::get('', ProjectIndex::class);
        Route::prefix('/{project}/{todos?}')
            ->where([
                'project' => '[a-z0-9]+(?:-[a-z0-9]+)*',
            ])
            ->group(function () {
                Route::get('', TodoIndex::class);
                Route::post('', Create::class);
            });
    });
});
