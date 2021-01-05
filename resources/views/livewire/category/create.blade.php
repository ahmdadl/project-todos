<div>
    <form class='grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3' wire:submit.prevent='submit' x-data="{title: @entangle('title').defer}">
        <div class='sm:col-span-2'>
            <x-jet-input class='form-input w-full' name='title' wire:model.defer='title' x-model='title'
                placeholder='Category Title' />
            <div class='mt-1 font-semibold'>
                <template x-if='!title.length'>
                    <span>
                        <x-jet-input-error for='title'></x-jet-input-error>
                    </span>
                </template>
                <i></i>
                <template x-if='title.length > 1 && title.length < 5'>
                    <p class='text-red-700 dark:text-red-400'>
                        {{__('validation.min.string', [
                            'attribute' => 'Title',
                            'min' => 5
                        ])}}
                    </p>
                </template>
            </div>
        </div>
        <div class='mt-1'>
            <x-jet-button :bg="$editMode ? 'indigo' : 'green'" type='submit' icon='fas fa-save' x-bind:disabled='!title.length || title.length < 5'>
                {{ $editMode ? 'update' : 'save' }}
            </x-jet-button>
            <x-jet-button bg='orange' wire:click.prevent='resetProps' icon='fas fa-times'>Reset</x-jet-button>
        </div>
    </form>
</div>
