<x-app-layout>
    @role('admin')
    <livewire:admin.transaksi />
    @endrole
    @role('user')
    <livewire:layanan.antrian />
    @endrole
    @role('driver')
    <livewire:driver.orderan />
    @endrole
    @guest
    <livewire:layanan.antrian />
    @endguest
</x-app-layout>