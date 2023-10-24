<div>
    <main class="app containerw pb-5">
        <div class="pb-3">
            <a href="{{ route('order') }}" class="btn btn-dark rounded shadow-sm "> Transaksi</a>
            <a href="{{ route('history') }}" class="btn btn-light rounded shadow-sm  mx-3 ">History Transaksi</a>
        </div>
        @if ($order)
        @if ($order->status === 'selesai' || $order->status === 'Batal' || $order->status === 'Timeout')

        <div class="card">
            <div class="card-body text-center">
                <h1 class="display-4 text-center ">TAXI RUTE</h1>
                <p>Anda Belum Lakukan Booking Saat ini</p>
                <a href="{{ route('home') }}" class="mb-3 btn btn-primary btn-sm">Booking Now</a>
                <img src="{{asset('assets/not.svg')}}" alt="User Image" srcset="" class="img-fluid">
            </div>
            @else
            <form autocomplete=" off" wire:submit.prevent="">
                <div class="pt-2">
                    @php
                    $parts = explode(" ",$order->date);
                    $firstPart = $parts[0];
                    @endphp
                    <div class="alert {{ $order->status == 'Aktif' ? 'alert-success' : 'alert-primary' }}" role="alert">
                        <h4 class="alert-heading">Status Booking...! <span class="badge badge-light">{{$order->status }}</span></h4>
                        <hr>

                        @if ($order->status == 'Menunggu Pembayaran' && $firstPart == now()->format('Y-m-d'))
                        <p class="form-text">Lakukan Pembayaran sebelum jam keberangkatan 15:00 , jika lewat pembatalan Order otomatis </p>
                        <p class="form-text"><span class="h3" id="waktu">..</span> </p>
                        @endif
                        @if ($driver)
                        @if ($driver->aktif == 2)
                        <h3 class="">Driver Anda Telah Siap, Dalam Perjalanan..</h3>
                        @endif
                        @endif


                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h4>Detail Booking</h4>
                                <h5 class="text-muted ">Tanggal Booking {{ $order->created_at->toFormatted() ?? 'N/A' }}</h5>
                            </div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="inputState">Nama : {{ auth()->user()->name }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Alamat</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->alamat }}">
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



                            </form>
                            <h6 class="text-bold">Nama Penumpang</h6>
                            <ul class="list-group mb-3">
                                @forelse ($personils as $index => $ts)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div> <span class="mr-1">{{ $index + 1 }}
                                        </span>
                                        {{ $ts->nama }}
                                    </div>
                                    @role('admin')
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" wire:click.prevent="edit({{ $ts }})" class="text-info"><i class="fa fa-edit mr-2"></i></a>
                                        <a wire:click.prevent="confirmRemoval({{ $ts }})" class="text-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endrole
                                </li>
                                @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    -
                                </li>
                                @endforelse
                            </ul>
                            <div class="d-flex justify-content-start">

                                @if ($order->status == 'Menunggu Pembayaran')
                                <button class="btn btn-primary btn-sm mr-2" id="pay-button">Pembayaran</button>
                                <button type="button" wire:click="confirmRemoval({{ $order }})" class="btn btn-danger btn-sm">Batal Booking</button>
                                @endif

                            </div>


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
                    <p class="text-muted">Sedang Dalam Antrian
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
                        <li class="list-group-item">No Tlpn : {{$driver->no_tlpn}}</li>
                    </ul>

                    @endif
                </div>
            </div>
            @endif
            @else
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-4 text-center ">TAXI RUTE</h1>
                    <p>Anda Belum Lakukan Booking Saat ini</p>
                    <a href="{{ route('home') }}" class="mb-3 btn btn-primary btn-sm">Booking Now</a>
                    <img src="{{asset('assets/not.svg')}}" alt="User Image" srcset="" class="img-fluid">
                </div>
            </div>
            @endif
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
    </main>
</div>
@if ($order->status ?? '' == 'Menunggu Pembayaran')
@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener("livewire:load", function() {
        // Ambil elemen dengan id "waktu"
        var waktuElement = document.getElementById("waktu");

        // Fungsi untuk memperbarui waktu secara real-time
        function perbaruiWaktu() {
            // Dapatkan objek tanggal dan waktu saat ini
            var now = new Date();

            // Format waktu menjadi HH:MM:SS
            var jam = now.getHours().toString().padStart(2, '0');
            var menit = now.getMinutes().toString().padStart(2, '0');
            var detik = now.getSeconds().toString().padStart(2, '0');

            // Gabungkan jam, menit, dan detik menjadi satu string
            var waktuString = jam + ":" + menit + ":" + detik;

            // Setel teks dalam elemen dengan id "waktu" menjadi waktu saat ini
            waktuElement.textContent = waktuString;
            var currentHour = now.getHours();

            // Periksa apakah jam saat ini adalah 15:00 (3:00 PM)
            if (currentHour === 15) {
                // Tampilkan pesan jika waktu saat ini adalah 15:00
                console.log("Sudah pukul 15:00! Waktunya untuk menampilkan pesan.");
                Livewire.emit('batalbooking');
            }
        }

        // Panggil fungsi perbaruiWaktu setiap detik (1000 milidetik)
        setInterval(perbaruiWaktu, 1000);

        // // Waktu target (contoh: 2023-10-02 18:00:00)
        // var targetTime = new Date("<$order->created_at ?>");
        // // var targetTime = new Date();
        // targetTime.setMinutes(targetTime.getMinutes() + 240);

        // function updateCountdown() {
        //     // Waktu saat ini
        //     var currentTime = new Date();

        //     // Hitung perbedaan waktu antara waktu saat ini dan waktu target
        //     var timeDifference = targetTime - currentTime;

        //     // Hitung jam, menit, dan detik
        //     var hours = Math.floor(timeDifference / (1000 * 60 * 60));
        //     var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

        //     // Format waktu
        //     var formattedTime = padZero(hours) + ":" + padZero(minutes) + ":" + padZero(seconds);

        //     // Tampilkan sisa waktu
        //     document.getElementById("countdown").textContent = "" + formattedTime;

        //     // Jika waktu sudah habis, tampilkan pesan
        //     if (timeDifference <= 0) {
        //         document.getElementById("countdown").textContent = "Waktu telah habis!";
        //         // Livewire.emit('updatedPaymentStatus');
        //         Livewire.emit('batalbooking');
        //     }
        // }

        // function padZero(num) {
        //     return (num < 10 ? "0" : "") + num;
        // }

        // // Perbarui hitungan mundur setiap detik
        // setInterval(updateCountdown, 1000);



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
@endif