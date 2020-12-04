@props(['icon', 'target', 'bg' => '', 'border' => 'px-3 py-2'])

    <button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center '.$border.' bg-'.$bg.'-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-'.$bg.'-700 active:bg-'.$bg.'-800 focus:outline-none focus:border-'.$bg.'-800 focus:shadow-outline-'.$bg.' disabled:opacity-25 transition ease-in-out duration-150', 
    'wire:loading.class' =>'cursor-not-allowed',
    'wire:loading.attr' => 'disabled',
    ]) }} @isset($target)wire:target='{{$target}}'@endisset>
        @isset($icon)
            <i class='{{ $icon }} px-1' @isset($target)wire:target='{{$target}}'@endisset wire:loading.class.remove='{{ $icon }}' wire:loading.class='fas fa-spin fa-cog'></i>
        @endisset
        {{ $slot }}
    </button>
