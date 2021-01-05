<div class='h-100 pb-10'>
    <x-slot name='title'>
        {{ $project->name }}
    </x-slot>

    <x-slot name='header'>
        <a href='/projects' class='hover:underline'>
            projects
        </a>
        <span class="px-1">/</span>
        <span class='text-gray-300'>{{ $project->name }}</span>
    </x-slot>

    <div class='mx-auto w-3/4 bg-gray-300 dark:bg-gray-800 mb-3 shadow' x-data='{users: []}' x-init="() => {window.Echo.join('todos.{{ $project->id }}')
        .here(allUsers => users = allUsers)
        .joining(user => users.push(user))
        .leaving(user => users.splice(
            users.findIndex(x => x.id === user.id), 1)
        )}" wire:ignore>
        <h2 class='bg-blue-600 dark:bg-blue-900 text-white p-2 font-bold'>Active Users</h2>
        <div class='list-none py-2 px-4'>
            <template x-for='(u, inx) in users' :key='u.id'>
                <div x-show="u.id !== '{{ \Hashids::encode(auth()->id()) }}'"
                    class='py-1 list-item border-gray-500 font-semibold'>
                    <img :src="u.image" class='w-10 h-10 rounded-full inline object-cover' />
                    <span x-text='u.name'></span>
                </div>
            </template>
        </div>
    </div>

    <livewire:todo.create :project="$project" />

    @forelse($todos as $todo)
        <livewire:todo.one :project='$project' :todo='$todo' :key='$todo->id . $todo->updated_at' />
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
