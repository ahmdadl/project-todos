<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait ProjectListFilters
{
    public function showOnlyCompleted(
        bool $toggle = true,
        ?Collection $collection = null
    ) {
        if ($toggle) {
            $this->onlyCompleted = !$this->onlyCompleted;
            $this->resetPage();
        }

        $this->getData($this->sortBy, false, true);
    }

    public function sortByHighCost()
    {
        $this->getData('desc');
    }

    public function sortByLowCost()
    {
        $this->getData('asc');
    }

    public function resetSortBy(): void
    {
        $this->getData('asc', false);
    }

    private function applySort(Collection $collection): Collection
    {
        $projects = $collection;

        if (!empty($this->sortBy)) {
            $projects =
                $this->sortBy === 'asc'
                    ? $projects->sortBy('cost')
                    : $projects->sortByDesc('cost');
        }

        return $projects;
    }

    private function applyFilters(): void
    {
        $projects = $this->applySort($this->allProjects);

        $this->showOnlyCompleted(false, $projects);
    }
}
