@props([
    'type' => 'primary',
])

<div {!! $attributes->merge(['class' => 'border rounded p-2 m-1 font-bold @if($type==="primary") border-indigo-900 bg-indigo-400 text-indigo-700 @elseif($type==="danger") border-red-900 bg-red-300 text-red-700 @elseif($type==="success") border-greed-800 bg-green-200 text-green-700 @endif']) !!} x-data="{show: true}" x-init="setTimeout(_ => show = false, 3500)" x-show="show">
    {{$slot}}
</div>