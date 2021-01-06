<div>

    <div class='p-2 mb-2'>
        <x-jet-button wire:click.prevent="openModal"
            class='bg-transparent border-2 border-teal-600 text-teal-600 hover:text-white hover:bg-teal-600 transition'
            icon='fas fa-plus' target='openModal'>add new project</x-jet-button>
    </div>
    <x-jet-dialog-modal wire:model.defer='showModal'>

        <x-slot name='title'>
            Add Project
        </x-slot>

        <x-slot name='content'>
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
                            <select wire:model.defer='categorySlug'
                                class='transition bg-transparent border-2 text-black border-gray-400 dark:border-gray-600 p-2 font-semibold dark:bg-gray-800 focus:border-green-500
                                disabled:opacity-50 invalid:border-red-500 @error('
                                categorySlug')border-red-500 @enderror' required @if($editMode) disabled='disabled'
                                @endif>
                                <option value=''>Select Category</option>
                                @foreach($categories as $category)
                                    <option value='{{ $category->slug }}' @if($category->slug === $categorySlug) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for='categorySlug'></x-jet-input-error>
                        </div>
                        <div>
                            <x-jet-input type='text' name='name' wire:model.defer='name' class='w-full'
                                placeholder='Name' autofocus required />
                            <x-jet-input-error for='name'></x-jet-input-error>
                        </div>

                        <div>
                            <x-jet-input type='text' name='cost' wire:model.defer='cost' class='w-full'
                                placeholder='Cost $' pattern="[0-9]+(\.[0-9]{1,2})?%?" required />
                            <x-jet-input-error for='cost'></x-jet-input-error>
                        </div>

                        <div x-data="{
                            img: '#',
                            read(ev) {
                                var input = ev.target;
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    
                                    reader.onload = (e) => {
                                      this.img = e.target.result;
                                    }
                                    
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        }">
                            <x-jet-input type='file' name='image' wire:model.defer='image' x-on:change="read"
                                class='w-full' placeholder='image' accept="image/png, image/jpg, image/jpeg" required />
                            <x-jet-input-error for='image'></x-jet-input-error>
                            <img :src="img" alt='preview image'
                                class='rounded-md border-2 border-gray-400 w-auto h-20 mx-auto mt-3 transform transition-all'
                                x-show="img !== '#'" x-on:reset-img.window="img = '#'" />
                        </div>

                        <div>
                            <input type='checkbox' id='completed' name='completed' wire:model.defer='completed'
                                class='' />
                            <label for='completed'>Completed</label>
                            <x-jet-input-error for='completed'></x-jet-input-error>
                        </div>
                    </div>
                </x-slot>

                <x-slot name='actions'>
                    <x-jet-button type='submit' class='bg-green-700 hover:bg-green-900 mx-1' icon='fas fa-save'>Save
                    </x-jet-button>
                    <x-jet-button type='reset' wire:click.prevent='resetProps'
                        class='bg-transparent border-gray-200 hover:bg-gray-700 hover:border-gray-700 mx-1'
                        icon='fas fa-times'>
                        reset</x-jet-button>
                </x-slot>
            </x-jet-form-section>
        </x-slot>
    </x-jet-dialog-modal>
</div>
