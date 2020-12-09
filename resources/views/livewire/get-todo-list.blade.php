<div class='h-100 pb-10'>
    <x-slot name='title'>
        {{ $category->title }}
    </x-slot>

    <x-slot name='header'>
        <a href='/categories' class='hover:underline'>
            Categories
        </a>
        <span class="px-1">/</span>
        <span class='text-gray-300'>{{ $category->title }}</span>
    </x-slot>

    <div class='p-2 mx-auto w-3/4 bg-gray-900 mb-3' x-data='{users: []}' x-init="window.Echo.join('todos.{{ $category->id }}')
        .here(allUsers => users = allUsers)
        .joining(user => users.push(user))
        .leaving(user => users.splice(
            users.findIndex(x => x.id === user.id), 1)
        )">
        <h2 class='bg-indigo-900 p-2 font-bold'>Active Users</h2>
        <ul class='list-none p-2'>
            <template x-for='(u, inx) in users' :key='u.id'>
                <li :class='{"text-green-300": users[inx].id === {{ auth()->id() }}}'
                    x-text='u.id === {{ auth()->id() }} ? `${u.name} (My Self)` : u.name'></li>
            </template>
        </ul>
    </div>

    <livewire:add-todo :category="$category" />

    @forelse($todos as $todo)
        <livewire:todo-list :category='$category' :todo='$todo' :key='$todo->id' />
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
