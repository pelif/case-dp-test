@props(['active'])

@php
$classes = ($active ?? false)
? 'nav-link active fw-bold text-white'
: 'nav-link text-white-50 hover-text-white';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
