<div>
    <x-slot name='header'>
        <a href='/categories'>Categories</a>
        /
        <span class='text-gray-300 dark:text-gray-400'>
            {{$category->title}}
        </span>
    </x-slot>

    <livewire:get-project-list :slug='$category->slug'>
</div>
