@props([
    'before',
])

<div {{ $attributes->class(['shortlink-auth-subheading', 'fi-simple-header-subheading', 'mt-2', 'text-center', 'text-sm']) }}>
    <span class="shortlink-auth-subheading__muted">{{ $before }}</span>
    {{ $slot }}
</div>
