<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Cache;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $usersCount = User::count('id');
        $projectsCount = Project::count('id');
        $teamCount = DB::table('project_user')->count('user_id');
        $todoCount = Todo::count('id');
        $checkedCount = Todo::whereCompleted(true)->count('id');

        return view(
            'home',
            compact(
                'usersCount',
                'projectsCount',
                'teamCount',
                'todoCount',
                'checkedCount'
            )
        );
    }
}
