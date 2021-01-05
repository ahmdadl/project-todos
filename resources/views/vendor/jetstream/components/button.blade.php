@props(['icon', 'target', 'bg' => '', 'border' => 'px-3 py-2', 'clear' => false, 'rounded' => true])

@php
    $bgClasses = $clear ? " text-$bg-500 bg-transparent hover:text-white border-$bg-500 " : ' bg-'.$bg.'-500 text-white border-transparent ';

    $rounded = $rounded ? 'rounded-md' : '';
@endphp

    <button {{ $attributes->merge([
    'type' => 'button', 
    'class' => 'inline-flex items-center hover:bg-'.$bg.'-700 active:bg-'.$bg.'-800' .$bgClasses. $border.' border '.$rounded.' font-semibold text-xs uppercase tracking-widest focus:outline-none focus:border-'.$bg.'-800 focus:shadow-outline-'.$bg.' disabled:opacity-25 transition ease-in-out duration-500', 
    'wire:loading.class' =>'cursor-not-allowed',
    'wire:loading.attr' => 'disabled',
    ]) }} @isset($target)wire:target='{{$target}}'@endisset>
        @isset($icon)
            <i class='{{ $icon }} px-1' @isset($target)wire:target='{{$target}}'@endisset wire:loading.class.remove='{{ $icon }}' wire:loading.class='fas fa-spin fa-spinner'></i>
        @endisset
        {{ $slot }}
    </button>
