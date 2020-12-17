<div>
    <x-slot name='title'>
        {{ $user->name }} Projects
    </x-slot>

    <div class='flex items-center justify-between py-2 px-4 w-100 bg-indigo-800 mb-5'>
        <h1 class='pt-2'>{{ $user->name }} Projects</h1>
        <div class='flex items-center'>
            <x-jet-button
                class="mx-1 {{ $this->onlyCompleted ? 'bg-red-300 hover:bg-red-700' : 'bg-green-600 hover:bg-green-800' }}"
                wire:click.prevent='showOnlyCompleted' :icon="$this->onlyCompleted ? 'fas fa-times' : 'fas fa-check'"
                target='showOnlyCompleted, sortByHighCost, sortByLowCost'>
                completed
            </x-jet-button>
            <x-jet-dropdown class='mx-1'>
                <x-slot name='trigger'>
                    <x-jet-button class='text-teal-600' icon='fas fa-filter'
                        target='sortByHighCost, sortByLowCost, resetSortBy'></x-jet-button>
                </x-slot>
                <x-slot name='content'>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Filter Projects') }}
                    </div>
                    <x-jet-dropdown-link wire:click.prevent="sortByHighCost"
                        class="{{ $sortBy === 'desc' ? 'bg-teal-800 hover:bg-teal-600' : '' }}">
                        <span
                            class='{{ $sortBy === 'desc' ? 'text-white ' : '' }}'>
                            <i class='fas fa-dollar-sign'></i>
                            <i class='fas fa-arrow-down'></i>
                            High Cost
                        </span>
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link wire:click.prevent="sortByLowCost"
                        class="{{ $sortBy === 'asc' ? 'bg-teal-800 hover:bg-teal-600' : '' }}">
                        <span
                            class='{{ $sortBy === 'asc' ? 'text-white ' : '' }}'>
                            <i class='fas fa-dollar-sign'></i>
                            <i class='fas fa-arrow-up'></i>
                            Low Cost
                        </span>
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link wire:click.prevent="resetSortBy"
                        class="{{ $sortBy === '' ? 'bg-red-800 hover:bg-red-600' : 'text-red-500' }}">
                        <span
                            class='{{ $sortBy === '' ? 'text-white' : '' }}'>
                            <i class='fas fa-times'></i>
                            reset
                        </span>
                    </x-jet-dropdown-link>
                </x-slot>
            </x-jet-dropdown>
        </div>
    </div>

    <livewire:add-project :user="$user" />

    <div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-3 md:gap-5'>
        @forelse($projects as $project)
            <livewire:one-project :project='$project' :user='$user' :key='$project->id . $project->name' :index='$loop->index'>
            @empty
                <div class='alert alert-danger w-3/4 hover:bg-red-400'>
                    you hadn`t created any projects yet.
                </div>
        @endforelse
    </div>
</div>