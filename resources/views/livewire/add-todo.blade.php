<div>
    <div class="mx-auto mb-4 w-3/4">
        <form wire:submit.prevent='submit' x-data="{body: ''}" class=''>
            <div class="inline">
                <x-jet-input type='text' class='bg-transparent border-gray-600 focus:bg-gray-700 indent-1 mb-2 w-3/4'
                    placeholder='Add New Task' wire:model.defer='body' x-model='body'
                    x-on:edit-mode.window="body = $event.detail" x-on:edit-mode-off.window="body = ''" />
                <x-jet-input-error for='body' class='w-3/4 mb-2 pt-1'></x-jet-input-error>
            </div>
            <div class='inline'>
                <x-jet-button type='submit'
                    class='bg-green-600 hover:bg-green-900 sm:inline uppercase disabled:bg-red-700' icon='fas fa-save'
                    x-bind:disabled='!body.length || body.length < 5'>
                    {{ $editMode ? 'update' : 'Save' }}
                </x-jet-button>
                @if($editMode)
                    <x-jet-button type='reset' class='bg-orange-600 hover:bg-orange-800 focus:bg-orange-800 uppercase'
                        wire:click="disableEditMode">
                        <i class='fas fa-times'></i>
                        cancel
                    </x-jet-button>
                @endif
            </div>
        </form>
    </div>
</div>
