<div>
    <main class="app containerw pb-5">
        @if ($status == 'Batal' || $status == 'selesai' || $status == 'kosong' || $status == 'Timeout')
        <a href="{{ route('home') }}" class="btn btn-primary rounded "><i class='bx bx-message-square-detail '></i> Booking</a>
        <a href="{{ route('charter') }}" class="btn btn-light rounded mx-3 "><i class='bx bx-message-square-detail '></i> Charter Mobil</a>

        <form autocomplete=" off" wire:submit.prevent="create">
            <div class="pb-5 pt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-primary pt-2 px-2 pb-1 mb-2 rounded">
                            <div class="d-flex justify-content-between">
                                <h3 id="waktu"></h3>
                                <p id="tanggal"></p>
                            </div>

                            @if ($statusdate == "opened")
                            <P>Batas Booking 14:00 Untuk hari ini</P>
                            <P>Keberangkatan Setiap Hari Jam 15:00</P>
                            @else
                            <P class="bg-danger" style="display: block;">Booking Telah ditutup untuk hari ini</P>
                            @endif

                        </div>
                        @if ($statusdate == "opened")
                        <div>
                            <div wire:click="toggleData" class="btn  {{ $data ? 'text-primary' : 'btn-danger' }}  mb-2">
                                {{ $data ? 'Tentukan Tanggal Keberangkatan' : 'Ubah Keberangkatan Hari Ini' }}
                            </div>
                        </div>
                        @else
                        <div class="mb-2 bg-dark p-4">
                            <div class="form-group ">
                                <label for="bookingDate">Buat Jadwal Keberangkatan</label>
                                <input type="date" class="form-control" id="bookingDate" wire:model.defer="bookingDate" min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        @endif
                        @if (!$data)
                        <div class="mb-2 bg-dark p-4">
                            <div class="form-group ">
                                <label for="bookingDate">Tanggal Keberangkatan max 3 hari kedepan</label>
                                <input type="date" class="form-control" id="bookingDate" wire:model.defer="bookingDate" min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Rute</label>
                            <select wire:model.defer="state.rute" class="form-control rute @error('rute') is-invalid @enderror">
                                <option value="">Pilih Rute</option>
                                <option value="Desa Saleman">Desa Saleman</option>
                                <option value="Desa Saka">Desa Saka</option>
                                <option value="Desa Wailulu">Desa Wailulu</option>
                                <option value="Desa SP 1">Desa SP 1</option>
                                <option value="Desa Hurale">Desa Hurale</option>
                                <option value="Desa Paa">Desa Paa</option>
                                <option value="Desa Karlutu">Desa Karlutu</option>
                                <option value="Desa Pasanea">Desa Pasanea</option>
                            </select>

                            @error('titikkor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputCity">Titik Penjemputan</label>
                            <div class="input-group">
                                <input type="text" name="titikkor" readonly id="titikkor" wire:model.defer="state.titikkor" class="form-control titikkor @error('titikkor') is-invalid @enderror" placeholder="Titik Penjemputan" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <a href="{{ route('maps') }}" class="btn btn-outline-primary " id="button-addon2">Go Maps</a>
                                </div>
                            </div>
                            @error('titikkor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Tlpn</label>
                            <input type="number" wire:model.defer="state.notlpn" class="form-control notlpn @error('notlpn') is-invalid @enderror" placeholder="08XXXX">

                            @error('notlpn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" wire:model.defer="state.alamat" class="form-control alamat @error('alamat') is-invalid @enderror" placeholder="Alamat">
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="add-input">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jumlah Penumpang</label>
                                        <input type="number" readonly wire:model.defer="state.jumlahpenumpang" id="jumlahPenumpang" class="form-control jumlah_penumpang  @error('jumlah_penumpang') is-invalid @enderror" id=" exampleInputEmail1" aria-describedby="emailHelp">
                                        <small class="form-text text-muted">Tarif Perorang Rp. 100.000</small>

                                        <input type="hidden" wire:model.defer="state.totalTarif" id="totalTarif" class="total">
                                        @error('jumlah_penumpang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-1">
                                    <label for="nama" class="text-white">tambah</label>
                                    <button class="btn btn-info" wire:click="add({{$i}})"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama penumpang</label>
                            <input type="text" wire:model.defer="nama.1" class="form-control @error('nama.1') is-invalid @enderror" id="nama" aria-describedby="nameHelp" placeholder="Enter Nama penumpang">
                            @error('nama.1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @foreach($inputs as $key => $value)
                        <div class="add-input">
                            <div class="row">
                                <div class="col-11">
                                    <div class="form-group">
                                        <input type="text" class="form-control  @error('nama.'.$value) is-invalid @enderror" placeholder="Enter Nama penumpang" wire:model.defer="nama.{{ $value }}">
                                        @error('nama.'.$value)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        @guest
                        <small class="form-text text-muted">Tidak Bisa <span class="badge badge-secondary">Booking</span> Silahkan <a href="{{ route('login') }}" class="ext-primary text-decoration-none">Login app</a> atau <a href="{{ route('register') }}" class="text-primary text-decoration-none">Belum Punya Akun</a> </small>
                        @endguest
                        @auth
                        <p></p>
                        <button type="submit" class="btn btn-primary">Booking Now </button>
                        @endauth
                    </div>
                </div>

            </div>
        </form>
        @else
        <div class="card">
            <div class="card-body">
                <h1 class="display-4 text-center ">TAXI RUTE</h1>
                <div class="text-center">
                    <a href="{{ route('order') }}" class="btn btn-primary btn-sm ">Go to Transaksi</a>
                </div>
                <img src="{{asset('assets/bus.svg')}}" alt="User Image" srcset="" class="img-fluid">
            </div>
        </div>
        @endif
    </main>
</div>
@push('js')
<script>
    document.addEventListener('livewire:load', function() {
        // Your JS here.
        const savedTitikkor = localStorage.getItem('titikkor'); // Mengambil data dari localStorage

        if (savedTitikkor) {
            const parsedTitikkor = JSON.parse(savedTitikkor); // Mengurai data JSON
            const {
                lat,
                lng
            } = parsedTitikkor; // Mendapatkan nilai lat dan lng

            // Mengisi nilai dalam elemen HTML dengan id 'titikkor'
            document.getElementById('titikkor').value = `${lat},${lng}`;

        } else {
            return null;
        }
    })
</script>
<script>
    document.addEventListener('livewire:load', function() {

        function updateDateTime() {
            var dateElement = document.getElementById("tanggal");
            var timeElement = document.getElementById("waktu");

            var currentDate = new Date();
            var options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            var formattedDate = currentDate.toLocaleDateString('id-ID', options);

            var hours = currentDate.getHours();
            var minutes = currentDate.getMinutes();
            var seconds = currentDate.getSeconds();
            var formattedTime = hours + ":" + (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;

            dateElement.textContent = "Tanggal " + formattedDate;
            timeElement.textContent = formattedTime;

            setTimeout(updateDateTime, 1000); // Update setiap 1 detik
        }

        // Panggil fungsi untuk pertama kali
        updateDateTime();

        const jumlahPenumpangInput = document.getElementById('jumlahPenumpang');
        const totalTarifSpan = document.getElementById('totalTarif');
        const totalTarifSpans = document.getElementById('totalTarifs');

        // Tarif per orang
        const tarifPerOrang = 100000;

        // Fungsi untuk menghitung dan memperbarui total tarif
        function updateTotalTarif() {
            const jumlahPenumpang = parseInt(jumlahPenumpangInput.value) || 0;
            const totalTarif = jumlahPenumpang * tarifPerOrang;

            totalTarifSpans.textContent = 'Rp. ' + totalTarif.toLocaleString();
            totalTarifSpan.value = totalTarif;

            // Simpan total tarif dalam localStorage
            localStorage.setItem('totalTarif', totalTarif);
        }

        // Event listener saat input berubah
        jumlahPenumpangInput.addEventListener('input', updateTotalTarif);

        // Panggil fungsi pertama kali untuk menginisialisasi total tarif
        updateTotalTarif();



    });
</script>
<script>
    $('form').submit(function() {
        @this.set('state.titikkor', $('.titikkor').val());
        @this.set('state.rute', $('.rute').val());
        @this.set('state.jumlah_penumpang', $('.jumlah_penumpang').val());
        @this.set('state.notlpn', $('.notlpn').val());
        @this.set('state.alamat', $('.alamat').val());
        @this.set('state.totalTarif', $('.total').val());
        localStorage.removeItem('titikkor');
    })
</script>

@endpush