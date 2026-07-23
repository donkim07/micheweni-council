@props(['value' => null, 'for'])

<label {{ $attributes->merge(['class' => 'form-label']) }} for="{{ $for }}">
    {{ $value ?? $slot }}
</label> 