<div>
    <form class='grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3' wire:submit.prevent='submit'>
        <div class='sm:col-span-2' x-data="{title: @entangle('title').defer}">
            <x-jet-input class='form-input w-full' name='title' wire:model.defer='title' x-model='title'
                placeholder='Category Title' />
            <div class='mt-1'>
                <x-jet-input-error for='title'></x-jet-input-error>
            </div>
        </div>
        <div class='mt-1'>
            <x-jet-button :bg="$editMode ? 'indigo' : 'green'"
                type='submit' icon='fas fa-save'>
                {{ $editMode ? 'update' : 'save' }}
            </x-jet-button>
            <x-jet-button bg='orange' wire:click.prevent='resetProps' icon='fas fa-times'>Reset</x-jet-button>
        </div>
    </form>
</div>
