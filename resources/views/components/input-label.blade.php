@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-200 transition-colors duration-300']) }}>
    {{ $value ?? $slot }}
</label>
