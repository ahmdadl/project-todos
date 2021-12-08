<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait ProjectListFilters
{
    public function showOnlyCompleted(): void
    {
        $this->onlyCompleted = !$this->onlyCompleted;

        $this->getData();
    }

    public function sortByHighCost(): void
    {
        $this->sortBy = 'high';
        $this->getData();
    }

    public function sortByLowCost(): void
    {
        $this->sortBy = 'low';
        $this->getData();
    }

    public function resetFilters(): void
    {
        if (!$this->onlyCompleted && $this->sortBy === '') {
            return;
        }

        $this->onlyCompleted = false;
        $this->sortBy = '';

        $this->getData();
    }

    private function applyFilters(): void
    {
        // only completed
        if ($this->onlyCompleted) {
            $this->projects = $this->allProjects->filter(
                fn($p) => $p->completed
            );
        }

        // sort by cost
        if ($this->sortBy) {
            $this->projects = $this->allProjects->sortBy('cost', SORT_REGULAR, $this->sortBy === 'high');
        }
    }
}
