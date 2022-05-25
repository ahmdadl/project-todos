<?php

namespace App\Http\Livewire\Project;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use App\Traits\HasToastNotify;
use App\Traits\ProjectListFilters;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Storage;
use Str;

class Index extends Component
{
    use HasToastNotify;
    use WithPagination;
    use ProjectListFilters;

    public Collection $allProjects;
    public Collection $projects;
    public User $user;
    public bool $onlyCompleted = false;
    // public bool $byCost = false;
    public string $sortBy = '';
    public bool $showModal = false;
    public ?string $slug = null;
    public ?int $categoryId = null;

    private int $projectsCount = 0;
    private int $teamProjectsCount = 0;

    protected int $perPage = 15;
    protected $queryString = [
        'sortBy' => [
            'as' => 'p',
            'except' => '',
        ],
        'onlyCompleted' => [
            'as' => 'c',
            'except' => false,
        ],
        // 'page' => ['except' => 1]
    ];

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

        $this->getData();

        if (null !== $this->slug) {
            $this->categoryId = Category::whereSlug($this->slug)->first(
                'id'
            )->id;
        }

        $this->projectsCount = $this->getProjectsCount();

        $this->teamProjectsCount = $this->getTeamProjectsCount();
    }

    public function hydrate()
    {
        $this->projectsCount = $this->getProjectsCount();
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

        return view('livewire.project.index', [
            'data' => $projects,
        ]);
    }

    public function getTotalCountProperty(): int
    {
        if (null !== $this->slug) {
            return $this->projectsCount;
        }

        return $this->page === 1
            ? $this->projectsCount + $this->teamProjectsCount
            : $this->projectsCount;
    }

    public function getOffsetProperty(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    private function getData(): void
    {
        // if (!$force) {
        //     if ($this->sortBy === $sortBy) {
        //         return;
        //     }
        // }

        $query = Project::with(['category', 'team'])
            ->withCount('todos')
            ->limit($this->perPage)
            ->offset($this->offset);

        if (null !== $this->slug) {
            $query->where(
                'category_id',
                '=',
                Category::whereSlug($this->slug)->first('id')->id
            );
        } else {
            $query->whereUserId($this->user->id);
        }

        if ($this->sortBy === 'high') {
            $query->orderBy('cost', 'DESC');
        } elseif ($this->sortBy === 'low') {
            $query->orderBy('cost', 'ASC');
        } else {
            $this->sortBy = '';
            $query->latest();
        }

        // check for completed filter
        if ($this->onlyCompleted) {
            $query->whereCompleted(true);
        }

        $this->allProjects = $query->get();

        // homepage only
        if (is_null($this->slug)) {
            if ($this->page === 1) {
                $teamProjects = $this->user->load('team_projects')
                    ->team_projects;

                $this->allProjects = $this->allProjects->merge($teamProjects);

                // apply filters

                // only completed
                if ($this->onlyCompleted) {
                    $this->allProjects = $this->allProjects->filter(
                        fn($p) => $p->completed
                    );
                }

                // sort by cost
                if ($this->sortBy) {
                    $this->allProjects = $this->allProjects->sortBy('cost', SORT_REGULAR, $this->sortBy === 'high');
                }
            }
        }

        $this->projects = $this->allProjects;
    }

    private function getProjectsCount(): int
    {
        if ($this->categoryId) {
            return Project::whereCategoryId($this->categoryId)->count('id');
        }

        return Project::whereUserId($this->user->id)->count('id');
    }

    private function getTeamProjectsCount(): int
    {
        if ($this->categoryId) {
            return 0;
        }

        return DB::table('project_user')
            ->whereUserId($this->user->id)
            ->count('user_id');
    }
}
