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
        @foreach($categories as $category)
            <livewire:category.one :category='$category' :key="$category->updated_at . $category->id"/>
        @endforeach
    </div>
</div>
