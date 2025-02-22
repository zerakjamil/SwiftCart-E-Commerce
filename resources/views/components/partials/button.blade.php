@props([
    'tag' => 'button',
    'type' => 'button',
    'href' => null,
    'route' => null,
    'class' => 'btn',
    'icon' => null,
    'value' => null,
    'title' => null,
])

@php
    $attributes = $attributes->merge(['class' => $class]);

    if ($route) {
        $href = route($route);
    }

    if ($href) {
        $tag = 'a';
        $attributes = $attributes->merge(['href' => $href]);
    } elseif ($tag === 'input') {
        $attributes = $attributes->merge(['type' => $type, 'value' => $value]);
    } else {
        $attributes = $attributes->merge(['type' => $type]);
    }

    if ($title) {
        $attributes = $attributes->merge(['title' => $title]);
    }
@endphp

@if($tag === 'input')
    <input {{ $attributes }}>
@else
    <{{ $tag }} {{ $attributes }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </{{ $tag }}>
@endif
