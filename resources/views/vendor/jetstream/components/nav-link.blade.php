@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-green-400 text-gray-100 bg-blue-800 dark:bg-gray-800 text-sm font-medium leading-5 focus:outline-none focus:border-gray-100 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-400 hover:text-gray-100  focus:outline-none focus:text-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
