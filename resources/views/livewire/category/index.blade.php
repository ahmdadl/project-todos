<div>
    <x-slot name='title'>
        All Categories
    </x-slot>

    <x-slot name='header'>
        Configure Categories
    </x-slot>

    <div class='my-4'>
        <div class='bg-gray-200 dark:bg-gray-700 mt-5 shadow'>
            <h5 class='text-2xl bg-blue-900 dark:bg-gray-900 text-white px-2 py-1'>
                Create New Category
            </h5>
            <div class='py-2 px-2 sm:px-4'>
                <livewire:category.create />
            </div>
        </div>
    </div>

    <div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5'>
        @foreach($categories as $cat)
            <div
                class="min-w-0 p-4 text-white {{ Arr::random(['bg-purple-600', 'bg-red-600', 'bg-blue-600', 'bg-orange-600', 'bg-yellow-600', 'bg-green-600']) }} rounded-lg shadow-xs m-2">
                <h4 class="mb-4 font-semibold">
                    <a href='/categories/{{ $cat->slug }}'
                        class='visited:text-white w-100 bg-transparent hover:border-gray-300 focus:shadow border-b-2 border-gray-700 transition-colors duration-500 cursor-pointer'>
                        {{ $cat->title }}
                        <span class='bg-gray-100 text-gray-600 hover:text-gray-800 rounded-full px-2'>
                            {{ $cat->projects_count ?? 0 }}
                        </span>
                    </a>
                </h4>
                <p class='text-gray-300'>
                    {{ $cat->slug }}
                </p>
                <hr class='border border-gray-300' />
                <div class='py-1'>
                    <x-jet-button bg='blue' icon='fas fa-edit' wire:click.prevent="$emit('edit', '{{ $cat->slug }}')">

                    </x-jet-button>
                    <x-jet-button bg='red' icon='fas fa-trash'
                        wire:click.prevent="$emit('delete', '{{ $cat->slug }}')">

                    </x-jet-button>
                </div>
            </div>
        @endforeach
    </div>
</div>
