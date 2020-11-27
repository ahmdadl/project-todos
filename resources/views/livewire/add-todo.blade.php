<div>
    <div class="mx-auto mb-4 w-3/4">
        <form wire:submit.prevent='store'>
            <div class="inline w-3/4">
                <x-jet-input type='text' class='bg-transparent border-gray-600 focus:bg-gray-100 indent-1 w-3/4'
                    placeholder='Add New Task' wire:model.lazy='body' />
                <x-jet-input-error for='body' class='w-3/4 pt-1'></x-jet-input-error>
            </div>
            <x-jet-button type='submit' class='bg-green-600 hover:bg-green-900 sm:inline disabled:opacity-50'
                wire:loading.attr='disabled' wire:loading.class='cursor-not-allowed'>Save</x-jet-button>
        </form>
    </div>
</div>
