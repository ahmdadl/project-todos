<div>
    <x-jet-form-section submit='save'>
        <x-slot name='title'>
            {{-- add new project to list --}}
        </x-slot>
        <x-slot name='description'>
            add new project owned by you
        </x-slot>

        <x-slot name='form'>

            <div class='grid grid-rows-1 gap-6 mt-3'>
                <div class=''>
                    <select wire:model.lazy='categorySlug'
                        class='bg-transparent border-2 border-gray-600 p-2 font-semibold focus:bg-gray-800 focus:border-green-500 transition invalid:border-red-500 @error('
                        categorySlug')border-red-500 @enderror' required>
                        <option>Select Category</option>
                        @foreach($categories as $category)
                            <option value='{{ $category->slug }}'>{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='categorySlug'></x-jet-input-error>
                </div>
                <div>
                    <x-jet-input type='text' name='title' wire:model.lazy='title' class='w-full' placeholder='Title'
                        autofocus required />
                    <x-jet-input-error for='title'></x-jet-input-error>
                </div>

                <div>
                    <x-jet-input type='text' name='cost' wire:model.lazy='cost' class='w-full' placeholder='Cost $'
                        pattern="[0-9]+(\.[0-9]{1,2})?%?" required />
                    <x-jet-input-error for='cost'></x-jet-input-error>
                </div>

                <div>
                    <input type='checkbox' id='completed' name='completed' wire:model.lazy='completed' class='' />
                    <label for='completed'>Completed</label>
                    <x-jet-input-error for='completed'></x-jet-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name='actions'>
            <x-jet-button type='submit' class='bg-green-700 hover:bg-green-900 mx-1' icon='fas fa-save'>Save</x-jet-button>
            <x-jet-button type='reset' wire:click.prevent='resetProps'
                class='bg-transparent border-gray-200 hover:bg-gray-700 hover:border-gray-700 mx-1' icon='fas fa-times'>reset</x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
