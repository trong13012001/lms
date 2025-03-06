<x-admin-layout>
    <x-slot name="title">Trang chủ</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('dashboard') }}
    </x-slot>
    <div class="d-flex justify-content-center">
        <img class="img-home shadow-sm rounded-3" src="/assets/4.jpg"/>
    </div>
    <x-slot name="css">
        <style>
            .block-rounded {
                background: transparent !important;
                box-shadow: none !important;
            }
            .img-home {
                max-width: 100%;
                max-height: calc(100vh - 184px);
            }
        </style>
    </x-slot>
</x-admin-layout>
