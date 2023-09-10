<div>
    <main class="app containerw pb-5">
        <a href="{{ route('home') }}" class="btn btn-light rounded "><i class='bx bx-message-square-detail '></i> Booking</a>
        <a href="{{ route('charter') }}" class="btn btn-dark rounded mx-3 "><i class='bx bx-message-square-detail '></i> Charter Mobil</a>
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
                                <div class="d-flex flex-row bd-highlight mb-3 align-items-end">
                                    <div class="rounded-circle overflow-hidden" style="height: 60px; width:60px">
                                        <img src="{{ $bg->user->avatar_url }}" class="card-img-top img-cover" alt="Raeesh">
                                    </div>
                                    <div class="px-3">
                                        <h5 class="">{{$bg->user->name}}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{$bg->nopolosi}}</h6>
                                    </div>

                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Muatan kapasitas : {{$bg->kapasitas}} orang</li>
                                    <li class="list-group-item"></li>
                                </ul>
                                @guest
                                <small class="form-text text-muted">Tidak Bisa <span class="badge badge-secondary">Booking</span> Silahkan <a href="{{ route('login') }}" class="ext-primary text-decoration-none">Login app</a> atau <a href="{{ route('register') }}" class="text-primary text-decoration-none">Belum Punya Akun</a> </small>
                                @endguest
                                @auth
                                <button type="submit" class="btn btn-success px-5">Booking Now</button>
                                @endauth
                            </div>
                        </article>
                        @empty
                        <article class="card__article swiper-slide">
                            <div class="card__image">
                                <img src="assets/1.png" alt="image" class="card__img">
                                <div class="card__shadow"></div>
                            </div>

                            <div class="card__data">
                                <div class="d-flex flex-row bd-highlight mb-3 align-items-end">
                                    <div class="rounded-circle overflow-hidden" style="height: 60px; width:60px">
                                        <img src="https://i.stack.imgur.com/fcbpv.jpg?s=256&g=1" class="card-img-top img-cover" alt="Raeesh">
                                    </div>
                                    <p>Not found</p>
                                </div>
                            </div>
                        </article>

                        @endforelse

                    </div>
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
         
            </div>
        </div>
    </main>
</div>
@push('css')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
@endpush
@push('js')
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/js/main.js') }}" defer></script>
@endpush