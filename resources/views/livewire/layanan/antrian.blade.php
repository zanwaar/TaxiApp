<div>
    @guest
    <main class="app containerw pb-5">
        <h5 class="font-weight-bolder">Silahkan Masuk Akun Terlebih dahulu</h5>
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login app</a>
    </main>
    @endguest
    @auth
    <main class="app containerw pb-5">
        @if ($status !== null)
        <p>Booking</p>
        <a href="{{ route('order') }}" class="btn btn-primary btn-sm">Go to Transaksi</a>
        @else
        <a href="{{ route('home') }}" class="btn btn-dark rounded "><i class='bx bx-message-square-detail '></i> Booking</a>
        <a href="{{ route('charter') }}" class="btn btn-light rounded mx-3 "><i class='bx bx-message-square-detail '></i> Charter Mobil</a>
        <form autocomplete=" off" wire:submit.prevent="create">
            <div class="pb-5 pt-3">
                <div class="card">
                    <div class="card-body">
                        <h4>Booking</h4>
                        <P>Keberangkatan Setiap Hari Jam 03:00 PM</P>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Rute</label>
                            <select wire:model.defer="state.rute" class="form-control @error('rute') is-invalid @enderror">
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
                            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                            @error('titikkor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Jumlah Penumpang</label>
                            <input type="number" wire:model.defer="state.jumlah_penumpang" class="form-control  @error('jumlah_penumpang') is-invalid @enderror" id=" exampleInputEmail1" aria-describedby="emailHelp" placeholder="0">
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
                                    <a href="{{ route('maps') }}" class="btn btn-danger" id="button-addon2">Maps</a>
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
                            <input type="text" wire:model.defer="state.notlpn" class="form-control @error('notlpn') is-invalid @enderror" placeholder="08XXXX">
                            <small class="form-text text-muted">Tarif Perorang Rp. 100.000</small>
                            @error('notlpn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" wire:model.defer="state.alamat" class="form-control @error('notlpn') is-invalid @enderror" placeholder="Alamat">
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success px-5">Booking Now</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </main>
    @endauth

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
    })
</script>

@endpush