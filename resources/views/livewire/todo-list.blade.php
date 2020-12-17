<div class="w-3/4 mx-auto rounded shadow mb-2 bg-gray-900" :key='$todo->id'>
    <div class='grid grid-cols-1 sm:grid-cols-2 font-semibold'>
        <div x-data="{completed: {{ $todo->completed? 1 : 0 }} }" class='px-2 py-2'>
            <x-jet-button border=''
                class='bg-transparent py-1 px-0 border-4 hover:border-white inline-block hover:text-white transition-all text-sm'
                x-bind:class="{'border-red-500 text-red-600 hover:bg-red-600': completed, 'border-green-500 text-green-600 hover:bg-green-600': !completed}"
                icon='fas fa-check' wire:click.prevent='check' target='check'>
            </x-jet-button>
            <span
                class="{{ $todo->completed ? 'line-through text-green-500' : '' }} inline-block">
                {{ $todo->body }}
            </span>
        </div>
        <div class='text-right'>
            <x-jet-button class='h-full -mr-1' rounded='0' bg='blue' wire:click.prevent='edit' icon='fas fa-edit' target='edit, check'>
            </x-jet-button>
            <x-jet-button class='h-full m-0' rounded='0' bg='red' wire:click.prevent="remove"
                icon='fas fa-trash-alt' target='remove, check'>
            </x-jet-button>
        </div>
    </div>
</div>
