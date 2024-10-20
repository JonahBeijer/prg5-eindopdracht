@props(['active' => false])

<a {{ $attributes->merge(['class' => $active ? 'active' : '']) }}>
    {{ $slot }}
</a>
