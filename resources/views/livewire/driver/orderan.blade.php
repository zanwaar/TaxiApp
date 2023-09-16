<div>
    <main class="app containerw pb-5">
        @if ($order)
        <h1 class="display-4 text-center ">TAXI RUTE</h1>
        <p class=" text-center ">Masohi - Pasanea</p>
        @forelse ($order as $index => $bg)
        <div class="list-group mb-2">
            <div class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h1 class="mb-1 text-muted">Layanan {{$bg->layanan}}</h1>
                    <p> <small class="badge badge-pill badge-{{ $bg->status_badge }}">Status : {{$bg->status}}</small></p>
                </div>
                <h3 class="mb-1 text-primary">Rute Taxi - {{$bg->rute}}</h3>
                <p class="mb-1">Nama : {{$bg->user->name}} <span>No Tlpn {{$bg->notlpn}}</span></p>
                <p class="mb-1">Alamat, {{$bg->alamat}}, Jumlah Penumpang : {{$bg->jumlah_penumpang}} Orang</p>
                <div class="d-flex w-100 justify-content-between">
                    <small class="text-muted">Titik Penjemputan {{$bg->titikkor}} , <a href="https://www.google.com/maps/place/{{$bg->titikkor}}" target="_blank" class="text-info" rel="noopener noreferrer">Link Google Maps</a></small>
                    @if ($bg->driver->aktif != 2)
                    <button wire:click="confirm({{ $bg }})" class="btn btn-primary btn-sm text-white">Terima Orderan</button>
                    @else
                    <button wire:click="confirmRemoval({{ $bg }})" class="btn btn-danger btn-sm text-white">Konfirmasi Selesai</button>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <p class="mt-2">No results found</p>
        @endforelse

        @else
        <div class="card">
            <div class="card-body">
                <h1 class="display-4 text-center ">TAXI RUTE</h1>
                <p class=" text-center ">Saat ini Belum Ada Orderan</p>
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" wire:click="refreshPage">Refresh Halaman</button>
                </div>

                <img src="{{asset('assets/bus.svg')}}" alt="User Image" srcset="" class="img-fluid">
            </div>
        </div>
        @endif
    </main>
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Konfirmasi</h5>
                </div>

                <div class="modal-body">
                    <h4>Konfirmasi</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="konfirmasi" class="btn btn-danger">save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('alpine-plugins')
<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
<script>
    window.livewire.on('refreshPage', () => {
        location.reload();
    });
</script>
@endpush