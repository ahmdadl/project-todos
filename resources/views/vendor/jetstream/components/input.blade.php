@props(['disabled' => false, 'model' => ''])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "form-input rounded-md shadow-sm transition"]) !!}>