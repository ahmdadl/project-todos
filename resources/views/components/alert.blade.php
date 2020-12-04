@props([
    'type' => 'primary',
    ])

    @php $alertId = ''; @endphp

        <div {!! $attributes->merge(['class' => 'border rounded p-2 m-1 font-bold @if($type==="primary")
            border-indigo-900 bg-indigo-400 text-indigo-700 @elseif($type==="danger") border-red-900 bg-red-300
            text-red-700 @elseif($type==="success") border-greed-800 bg-green-200 text-green-700 @endif']) !!}
            x-data="{show{{ $alertId }}: true}" x-init="setTimeout(_ => {if (typeof show{{ $alertId }} !== 'undefined') show{{ $alertId }} =
            false;}, 3500)" x-show="show{{ $alertId }}" {{--  x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform
            scale-100" x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100
            transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" --}} >
            {{ $slot }}
        </div>
