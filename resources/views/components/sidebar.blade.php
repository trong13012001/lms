@props(['active', 'href', 'icon', 'name', 'submenu'])

@php
    $classes = ($active ?? false) ? 'nav-main-link active' : 'nav-main-link';
@endphp

<li class="nav-main-item">
    <a {{ $attributes->merge(['class' => $classes]) }} {{ $attributes->merge(['href' => $href]) }}>
        @if ($submenu == false)
            <i class="nav-main-link-icon {{ $icon }}"></i>
        @endif
        <span class="nav-main-link-name">{{ $name }}</span>
    </a>
</li>
