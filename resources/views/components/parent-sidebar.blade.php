@props(['name', 'icon'])

@php
    $isActive = str_contains($slot, 'active');
    $classes = $isActive ? 'nav-main-item open' : 'nav-main-item';
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ $isActive ? 'true' : 'false' }}" href="#">
        <i class="nav-main-link-icon {{ $icon }}"></i>
        <span class="nav-main-link-name">{{ $name }}</span>
    </a>
    <ul class="nav-main-submenu" style="padding-left: 10px !important;">
        {{ $slot }}
    </ul>
</li>
