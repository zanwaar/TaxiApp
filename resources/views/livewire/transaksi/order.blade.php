<div>
    <main class="app containerw pb-5">
        @if ($order)
        @if ($order->status === 'selesai')
        <h4>Order Masih Kosong</h4>
        <a href="{{ route('home') }}" class="btn btn-primary  btn-sm">Booking Now</a>
        @else
        <form autocomplete=" off" wire:submit.prevent="">
            <div class="pt-2">
                <div class="alert {{ $order->status == 'Aktif' ? 'alert-success' : 'alert-primary' }}" role="alert">
                    <h4 class="alert-heading">Status Booking...! <span class="badge badge-light">{{$order->status}}</span></h4>
                    <hr>
                    <p class="mb-0">Informasi</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>Detail Booking</h4>
                        </div>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputState">Nama : {{ auth()->user()->name}}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputState">Rute</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->rute }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">No Telepon</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->notlpn }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Jml Penumpang</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->jumlah_penumpang }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Alamat</label>
                                <input type="text" class="form-control" readonly value="{{ $order->alamat }}">
                            </div>


                        </form>
                        <div class="d-flex justify-content-start">

                            @if ($order->status == 'Menunggu Pembayaran')
                            <button class="btn btn-primary btn-sm mr-2" id="pay-button">Pembayaran</button>
                            @endif
                            <button type="button" wire:click="confirmRemoval({{ $order }})" class="btn btn-danger btn-sm">Batal Booking</button>

                        </div>

                        <small class="form-text text-muted">Pembatalan Order di bisa di lakukan ......</small>
                    </div>

                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                @if ($driver === null)
                <style>
                    svg {
                        width: 100px;
                        height: 100px;
                        margin: 0;
                        display: inline-block;
                    }
                </style>
                <h4>Keberangkatan Setiap Hari Jam 03:00 PM</h4>
                <p class="text-muted">Sedang Dalam Antrian, Segera Lakukan Pembayaran 
                    <span class="ml-2">
                        <svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <circle fill="#2D4356" stroke="none" cx="6" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1" />
                            </circle>
                            <circle fill="#2D7ABE" stroke="none" cx="26" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2" />
                            </circle>
                            <circle fill="#2D4356" stroke="none" cx="46" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3" />
                            </circle>
                        </svg>
                    </span>
                </p>
                @else
                <h3>Taxi Driver</h3>
                <div class="border border-dark rounded shadow-sm" style="position: relative;">
                    <img src="{{ $driver->user->avatar_url }}" style="border-radius: 50%; height: 80px; width:80px;   position:absolute; top:10px; left:10px" alt="Raeesh">
                    <img src="{{ $driver->avatar_url }}" alt="image" class="card__img">
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nama Driver : {{$driver->user->name}}</li>
                    <li class="list-group-item ">Nomor Polisi : <span class="bg-secondary px-1 rounded">{{$driver->nopolisi}}</span></li>
                    <li class="list-group-item">Muatan kapasitas : {{$driver->kapasitas}} orang</li>
                </ul>

                @endif
            </div>
        </div>
        @endif
        @else
        <p>Anda Belum Lakukan Booking</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Booking Now</a>
        @endif
    </main>
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete</h5>
                </div>

                <div class="modal-body">
                    <h4>Apakah Anda Yakin Untuk Batal Booking?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="delete" class="btn btn-danger">Ya</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener("livewire:load", function() {
        const payButton = document.querySelector('#pay-button');

        if (payButton) {
            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // Callback ketika pembayaran berhasil
                        console.log(result);
                        Livewire.emit('updatedPaymentStatus');
                        Livewire.emit('booking');
                    },
                    onPending: function(result) {
                        console.log(result);
                    },
                    onError: function(result) {
                        console.log(result);
                    },

                });
            });
        }
    });
</script>
@endpush