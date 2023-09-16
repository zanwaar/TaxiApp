<div>
    <main class="app containerw pb-5">
        @if ($status === 'selesai')
        <p>Booking Charter</p>
        <a href="{{ route('order') }}" class="btn btn-primary btn-sm">Go to Transaksi</a>

        @else
        @if ($driver === null)
        <p>Booking</p>
        <a href="{{ route('order') }}" class="btn btn-primary btn-sm">Go to Transaksi</a>

        @else

        <a href="{{ route('charter') }}" class="btn btn-outline-primary rounded btn-sm ">Kembali</a>

        <form autocomplete=" off" wire:submit.prevent="create">
            <div class="pb-5 pt-3">
                <div class="card">
                    <div class="card-body">
                        <h4>Charter Mobil</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="border border-dark rounded shadow-sm" style="position: relative;">
                                    <img src="{{ $driver->user->avatar_url }}" style="border-radius: 50%; height: 80px; width:80px;   position:absolute; top:5px; left:5px; z-index: 99;" alt="Raeesh">
                                    <img src="{{ $driver->avatar_url }}" alt="image" class="card__img">
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Nama Driver : {{$driver->user->name}}</li>
                                    <li class="list-group-item ">Nomor Polisi : <span class="bg-secondary px-1 rounded">{{$driver->nopolisi}}</span></li>
                                    <li class="list-group-item">Muatan kapasitas : {{$driver->kapasitas}} orang</li>
                                </ul>
                                <hr>
                                <h4 class="text-muted">Biaya Charter Rp 1.000.000 </h4>


                            </div>
                            <div class="col-md-6">
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

                                    @error('rute')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jumlah Penumpang</label>
                                    <input type="number" wire:model.defer="state.jumlah_penumpang" class="form-control jumlah_penumpang  @error('jumlah_penumpang') is-invalid @enderror" id=" exampleInputEmail1" aria-describedby="emailHelp" placeholder="0">
                                    <small class="form-text text-muted">Tarif Perorang Rp. 100.000</small>
                                    @error('jumlah_penumpang')
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
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @guest
                        <small class="form-text text-muted">Tidak Bisa <span class="badge badge-secondary">Booking</span> Silahkan <a href="{{ route('login') }}" class="ext-primary text-decoration-none">Login app</a> atau <a href="{{ route('register') }}" class="text-primary text-decoration-none">Belum Punya Akun</a> </small>
                        @endguest
                        @auth
                        <button type="submit" class="btn btn-primary px-5">Booking Now</button>
                        @endauth
                    </div>
                </div>
            </div>
        </form>
        @endif
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
    $('form').submit(function() {
        @this.set('state.titikkor', $('.titikkor').val());
        @this.set('state.rute', $('.rute').val());
        @this.set('state.jumlah_penumpang', $('.jumlah_penumpang').val());
        @this.set('state.notlpn', $('.notlpn').val());
        @this.set('state.alamat', $('.alamat').val());
        localStorage.removeItem('titikkor');
    })
</script>

@endpush