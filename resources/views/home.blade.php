<x-app-layout>
    @role('admin')
    <livewire:admin.dashboard />
    @else
    <livewire:layanan.antrian />
    @endrole
</x-app-layout>