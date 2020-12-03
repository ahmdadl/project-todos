<div class='h-100 pb-10'>
    <h2 class="bg-indigo-800 text-gray-100 w-100 py-3 px-4 mb-4">
        {{ $category->title }}
    </h2>

    <livewire:add-todo :category="$category" />

    @forelse($todos as $todo)
        <div class="w-3/4 mx-auto py-2 px-3 rounded shadow mb-2 bg-gray-900">
            <p class='block w-100 font-bold'>
                <span
                    class="{{ $todo->done ? 'line-through text-green-500' : '' }}">
                    {{ $todo->body }}
                </span>
                <button
                    class='bg-red-700 hover:bg-red-900 focus:bg-red-900 py-1 px-2 font-bold uppercase disabled:opacity-50'
                    wire:click.prevent="remove({{ $todo->id }})" wire:loading.attr='disabled'
                    wire:loading.class='cursor-not-allowed'>
                    x
                </button>
            </p>
        </div>
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
