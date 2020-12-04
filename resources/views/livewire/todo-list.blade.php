<div class="w-3/4 mx-auto py-2 px-3 rounded shadow mb-2 bg-gray-900" :key='$todo->id'>
    <p class='block w-100 font-bold'>
        <div class='inline' x-data="{completed: {{ $todo->completed? 1 : 0 }} }">
            <x-jet-button border=''
                class='bg-transparent py-1 px-0 border-4 hover:border-white inline-block hover:text-white transition-all text-sm'
                x-bind:class="{'border-red-500 text-red-600 hover:bg-red-600': completed, 'border-green-500 text-green-600 hover:bg-green-600': !completed}"
                icon='fas fa-check' wire:click.prevent='check' target='check'>
            </x-jet-button>
        </div>
        <span
            class="{{ $todo->completed ? 'line-through text-green-500' : '' }} inline-block">
            {{ $todo->body }}
        </span>
        <div class='py-2 inline-block'>
            <x-jet-button bg='blue' wire:click.prevent='edit' icon='fas fa-edit' target='edit, check'>
            </x-jet-button>
            <x-jet-button class='bg-red-700 hover:bg-red-900 focus:bg-red-900 uppercase' wire:click.prevent="remove"
                icon='fas fa-trash-alt' target='remove, check'>
            </x-jet-button>
        </div>
    </p>
</div>
