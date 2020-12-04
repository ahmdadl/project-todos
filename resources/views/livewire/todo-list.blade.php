<div class='h-100 pb-10'>
    <h2 class="bg-indigo-800 text-gray-100 w-100 py-3 px-4 mb-4">
        {{ $category->title }}
    </h2>

    <livewire:add-todo :category="$category" />

    @forelse($todos as $todo)
        <div class="w-3/4 mx-auto py-2 px-3 rounded shadow mb-2 bg-gray-900" :key='$todo->id'>
            <p class='block w-100 font-bold'>
                <span
                    class="{{ $todo->done ? 'line-through text-green-500' : '' }}">
                    {{ $todo->body }}
                </span>
                <x-jet-button class='bg-blue-600 hover:bg-blue-800 focus:bg-blue-800 p-1'
                    wire:click.prevent='edit({{ $todo->id }})' icon='fas fa-edit' target='edit({{ $todo->id }})'>
                </x-jet-button>
                <x-jet-button class='bg-red-700 hover:bg-red-900 focus:bg-red-900 uppercase disabled:opacity-50 p-1'
                    wire:click.prevent="remove({{ $todo->id }})" icon='fas fa-trash-alt'
                    target='remove'>
                </x-jet-button>
            </p>
        </div>
    @empty
        <div class="bg-orange-500 text-gray-300 py-2 px-4 w-3/4 mx-auto">
            No Todos Here, Add More
        </div>
    @endforelse
</div>
