<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use App\Traits\HasToastNotify;
use App\Traits\ProjectListFilters;
use DB;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class GetProjectList extends Component
{
    use HasToastNotify;
    use WithPagination;
    use ProjectListFilters;

    public Collection $allProjects;
    public Collection $projects;
    public User $user;
    public bool $onlyCompleted = false;
    public string $sortBy = '';
    public bool $showModal = false;

    private int $projectsCount = 0;
    private int $teamProjectsCount = 0;

    protected int $perPage = 15;

    protected $listeners = [
        'modal:closed' => 'closeModal',
        'project:added' => 'appendProject',
        'project:updated' => 'updateProject',
        'project:deleted' => 'removeProject',
        'echo:projects,ProjectUpdated' => 'echoUpdateProject',
        'echo:projects,ProjectDeleted' => 'echoRemoveProject',
    ];

    public function mount()
    {
        $this->user = auth()->user();

        $this->getData('asc', false);

        $this->projectsCount = Project::whereUserId($this->user->id)->count(
            'id'
        );

        $this->teamProjectsCount = DB::table('project_user')
            ->whereUserId($this->user->id)
            ->count('user_id');
    }

    public function hydrate()
    {
        $this->getData('asc', false);

        $this->projectsCount = Project::whereUserId($this->user->id)->count(
            'id'
        );
    }

    public function appendProject(Project $project)
    {
        $this->allProjects->prepend($project);

        $this->applyFilters();

        $this->emit('modal:close');
    }

    public function updateProject(Project $project)
    {
        $this->allProjects->each(function (Project $p) use ($project) {
            if ($project->slug === $p->slug) {
                $p->name = $project->name;
                $p->cost = $project->cost;
                $p->completed = $project->completed;
            }
        });

        $this->applyFilters();

        $this->emit('modal:close');
    }

    public function removeProject(string $slug)
    {
        $this->allProjects
            ->each(fn($p) => $p->slug === $slug ? null : $p)
            ->values();

        $this->projects
            ->each(fn($p) => $p->slug === $slug ? null : $p)
            ->values();
    }

    public function echoUpdateProject($ev)
    {
        $project = new Project($ev['project']);

        if ($this->user->cannot('teamMember', $project)) {
            return;
        }

        $this->success(
            'Project (' .
                Str::limit($project->name, 20) .
                ') Was Updated by (' .
                $ev['userName'] .
                ')'
        );

        $this->updateProject($project);
    }

    public function echoRemoveProject($ev)
    {
        //
    }

    public function render()
    {
        $projects = new LengthAwarePaginator(
            $this->projects,
            $this->total_count,
            $this->perPage,
            $this->page
        );

        return view('livewire.get-project-list', [
            'data' => $projects,
        ]);
    }

    public function getTotalCountProperty(): int
    {
        return $this->page === 1
            ? $this->projectsCount + $this->teamProjectsCount
            : $this->projectsCount;
    }

    public function getOffsetProperty(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    private function getData(
        string $sortBy = 'asc',
        bool $sort = true,
        bool $force = false
    ): void {
        if (!$force) {
            if ($this->sortBy === $sortBy && $sort) {
                return;
            }
        }

        $query = Project::whereUserId($this->user->id)
            ->with(['category', 'team'])
            ->withCount('todos')
            ->limit($this->perPage)
            ->offset($this->offset);

        if ($sort) {
            $query->orderBy('cost', $sortBy);
            $this->sortBy = $sortBy;
        } else {
            $this->sortBy = '';
            $query->latest();
        }

        // check for completed filter
        if ($this->onlyCompleted) {
            $query->whereCompleted(true);
        }

        $this->allProjects = $query->get();

        if ($this->page === 1) {
            $teamProjects = $this->user->load('team_projects')->team_projects;

            $this->allProjects = $this->allProjects->merge($teamProjects);
        }

        $this->projects = $this->allProjects;
    }
}
