<div class='h-100 pb-10'>

    <x-slot name='header'>
        <a href='/categories' class='hover:underline'>
            Categories
        </a>
        <span class="px-1">/</span>
        <span class='text-gray-300'>{{ $category->title }}</span>
    </x-slot>

    <livewire:add-todo :category="$category" />

    @forelse($todos as $todo)
        <livewire:todo-list :category='$category' :todo='$todo' :key='$todo->id' />
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
