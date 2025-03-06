<x-admin-layout>
    <x-slot name="title">Quản lý tập tin</x-slot>
    <div class="show-file-manager">
        <iframe src="{{ route('file-manager-dashboard') }}" frameborder="0" width="100%" height="100%"></iframe>
    </div>
    <x-slot name="css">
        <style>
            .show-file-manager {
                width: 100%;
                height: calc(100vh - 184px);
            }
        </style>
    </x-slot>
</x-admin-layout>
