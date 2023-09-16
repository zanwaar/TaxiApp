<div>
    <main class="app containerw pb-5">
        @if ($status == 'Batal' || $status == 'selesai' || $status == null)
        <a href="{{ route('home') }}" class="btn btn-light rounded "><i class='bx bx-message-square-detail '></i> Booking</a>
        <a href="{{ route('charter') }}" class="btn btn-primary rounded mx-3 "><i class='bx bx-message-square-detail '></i> Charter Mobil</a>
        <h3 class="pt-3">Charter Mobil</h3>
        <p>Carter merupakan jasa layanan transportasi yang memungkinkan calon penumpang untuk memilih jenis mobil tertentu tanpa adanya tambahan penumpang lainnya (Private Car).</p>
        <div class="containerr my-4">
            <div class="card__container swiper">
                <div class="card__content mb-5">
                    <div class="swiper-wrapper">
                        @forelse ($driver as $index => $bg)
                        <article class="card__article swiper-slide">
                            <div class="card__image">
                                <img src="{{ $bg->avatar_url }}" alt="image" class="card__img">
                                <div class="card__shadow"></div>
                            </div>

                            <div class="card__data">
                                <div class="d-flex flex-row align-items-center">
                                    <div>
                                        <img src="{{ $bg->user->avatar_url }}" style="border-radius: 50%; height: 60px; width:60px;   " alt="Raeesh">
                                    </div>
                                    <div class="px-3">
                                        <h5 class="">{{$bg->user->name}}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{$bg->nopolosi}}</h6>
                                    </div>

                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Muatan kapasitas : {{$bg->kapasitas}} orang</li>
                                </ul>
                                @guest
                                <small class="form-text text-muted">Tidak Bisa <span class="badge badge-secondary">Booking</span> Silahkan <a href="{{ route('login') }}" class="ext-primary text-decoration-none">Login app</a> atau <a href="{{ route('register') }}" class="text-primary text-decoration-none">Belum Punya Akun</a> </small>
                                @endguest
                                @auth
                                <a href="{{ route('charter.booking', $bg->id) }}" class="btn btn-primary px-5">Booking Now</a>
                                @endauth
                            </div>
                        </article>
                        @empty

                        @endforelse

                    </div>
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>

            </div>
        </div>
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
@push('css')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
@endpush
@push('js')
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/js/main.js') }}" defer></script>
@endpush