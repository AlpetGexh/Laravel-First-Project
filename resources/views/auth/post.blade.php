<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('AdminPanel/plugins/select2/css/select2.min.css') }}">
    @endpush
    <x-slot name="header">
        {{ __('Krijo Postime') }}
    </x-slot>
    {{-- Postime --}}
    <x-jet-authentication-card>
        <x-slot name="logo"> </x-slot>
        <livewire:post.post>
    </x-jet-authentication-card>

    {{-- Kategori --}}
    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>
        <livewire:category.create>
    </x-jet-authentication-card>
    @push('scripts')
        <script src="{{ asset('AdminPanel/plugins/select2/js/select2.full.min.js') }}"></script>

        <script>
            $(function() {
                $('.select2').select2()
            });
        </script>
    @endpush
</x-app-layout>
