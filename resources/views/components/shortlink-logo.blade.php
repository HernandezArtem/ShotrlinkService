@props([
    'href' => null,
    'size' => 'md',
    'theme' => 'dark',
])

@php
    $sizes = [
        'sm' => ['mark' => '1.75rem', 'font' => '0.95rem', 'icon' => '0.85rem'],
        'md' => ['mark' => '2.25rem', 'font' => '1.15rem', 'icon' => '1.1rem'],
        'lg' => ['mark' => '2.75rem', 'font' => '1.5rem', 'icon' => '1.35rem'],
    ];

    $s = $sizes[$size] ?? $sizes['md'];
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class([
        'shortlink-logo',
        'shortlink-logo--' . $theme,
        'shortlink-logo--' . $size,
    ]) }}
    @if ($href) aria-label="ShortLink — на главную" @endif
>
    <span class="shortlink-logo__mark" style="width: {{ $s['mark'] }}; height: {{ $s['mark'] }};">
        <img src="{{ asset('favicon.svg') }}" alt="" class="shortlink-logo__icon" width="32" height="32">
    </span>
    <span class="shortlink-logo__text" style="font-size: {{ $s['font'] }};">
        Short<span class="shortlink-logo__accent">Link</span>
    </span>
</{{ $tag }}>
