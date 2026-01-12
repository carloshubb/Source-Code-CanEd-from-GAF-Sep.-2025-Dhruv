@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-base lg:text-lg text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
