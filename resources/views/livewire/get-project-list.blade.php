<div>
    <x-slot name='title'>
        {{ $user->name }} Projects
    </x-slot>

    @include('project.index.header')

    <livewire:add-project :user="$user" />

    @include('project.index.list-loader')

    <div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-3 md:gap-5' wire:loading.class='hidden'>
        @forelse($data as $project)
            <livewire:one-project :project='$project' :user='$user' :key='$project->id . $project->updated_at'
                :index='$loop->index'>
            @empty
                <div class='alert alert-danger w-3/4 hover:bg-red-400'>
                    you hadn`t created any projects yet.
                </div>
        @endforelse
    </div>
    <hr class="my-1 border border-gray-800 dark:border-gray-300" />
    <div class='py-3'>
        {{ $data->links() }}
    </div>
</div>
