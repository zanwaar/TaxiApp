@role('admin')
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml" href="https://demo.themesberg.com/landwind/images/logo.svg" />
    <title>DrivGo - Taxi Online Terpercaya</title>
    @stack('jsheader')
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @stack('styles')
    @stack('css')
    <livewire:styles />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div id="main-wrapper" class="wrapper">
        <div class="body-overlay"></div>
        <nav id="sidebar" class="shadow-sm">
            <div class="sidebar-header ">
                <p class="text-center">
                    <img src="https://demo.themesberg.com/landwind/images/logo.svg" class="mr-3" width="50%" alt="DraivGo Logo" />

                </p>
            </div>
            <p class="text-center text-xl text-bold m-0">DrivGo</p>
            <hr class="mb-0 p-0">
            <ul class="list-unstyled components custom">
                <!-- <li class="{{ request()->is('dashboard') | request()->is('/')  ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
                </li> -->

                <li class="{{ request()->is('transaksi') ? 'active' : '' }}">
                    <a href="{{ route('transaksi') }}"><i class="material-icons">sync_alt</i><span>Transaksi</span></a>
                </li>
                <li class="{{ request()->is('driver') ? 'active' : '' }}">
                    <a href="{{ route('driver') }}"><i class="material-icons">recent_actors</i><span>Driver</span></a>
                </li>

                <li class="{{ request()->is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}"><i class="material-icons">manage_accounts</i><span>Profile</span></a>
                </li>
                <li class="">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="material-icons">logout</i><span>Logout</span></a>
                    </form>
                </li>
            </ul>
        </nav>
        <div id="content">
            <div class="top-navbar bg-white">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid ">
                        <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none text-dark">
                            <span class="material-icons">menu</span>
                        </button>
                        @stack('nav')
                        <button class="d-inline-block d-lg-none ml-auto btn btn-white more-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="material-icons">more_vert</span>
                        </button>
                    </div>
                </nav>
            </div>
            <div class="main-content">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/backend.js')}}"></script>
    <livewire:scripts />
    @stack('js')
    @stack('alpine-plugins')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
@else
<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <link rel="icon" type="image/svg+xml" href="https://demo.themesberg.com/landwind/images/logo.svg" />
    <title>DrivGo - Taxi Online Terpercaya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/costume.css') }}" rel="stylesheet">
    @stack('css')
    @stack('styles')
    <link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    <header class="headerw" id="headerw">
        <nav class="navw containerw">
            <a href="#" class="navw__logo">
                <img src="https://demo.themesberg.com/landwind/images/logo.svg" class="mr-3" alt="DraivGo Logo" />
                <span class="text-lg">DraivGo</span>
            </a>
            <div class="navw__menu" id="navw-menu">
                <ul class="navw__list" style="padding-left: 0px !important;  margin-bottom: 0px !important;">
                    @role('driver')
                    <!-- <li class="navw__item">
                        <a href="{{ route('beranda') }}" class="navw__link {{ request()->is('beranda') ? 'active-link' : '' }}">
                            <i class='bx bx-home-alt navw__icon'></i>
                            <span class=" navw__name">Beranda</span>
                        </a>
                    </li> -->
                    <li class="navw__item">
                        <a href="{{ route('orderan') }}" class="navw__link {{ request()->is('orderan') | request()->is('/') ? 'active-link' : '' }}">
                            <i class='bx bx-home-alt navw__icon'></i>
                            <span class=" navw__name">Beranda</span>
                        </a>
                    </li>
                    <li class="navw__item ">
                        <a href="{{ route('dtransaksi') }}" class="navw__link {{ request()->is('dtransaksi')  ? 'active-link' : '' }}">
                            <i class='bx bx-briefcase-alt navw__icon'></i>
                            <span class="navw__name">Transaksi</span>
                        </a>
                    </li>
                    <li class="navw__item">
                        <a href="{{ route('profile.edit') }}" class="navw__link {{ request()->is('profile') ? 'active-link' : '' }}">
                            <i class='bx bx-user navw__icon'></i>
                            <span class="navw__name">Profile</span>
                        </a>
                    </li>

                    @else
                    <li class="navw__item">
                        <a href="{{ route('home') }}" class="navw__link {{ request()->is('charter') | request()->is('home') | request()->is('/') ? 'active-link' : '' }}">
                            <i class='bx bx-home-alt navw__icon'></i>
                            <span class=" navw__name">Beranda</span>
                        </a>
                    </li>
                    <li class="navw__item ">
                        <a href="{{ route('order') }}" class="navw__link {{ request()->is('order') |  request()->is('history') ? 'active-link' : '' }}">
                            <i class='bx bx-briefcase-alt navw__icon'></i>
                            <span class="navw__name">Transaksi</span>
                        </a>
                    </li>
                    <li class="navw__item">
                        <a href="{{ route('profile.edit') }}" class="navw__link {{ request()->is('profile') ? 'active-link' : '' }}">
                            <i class='bx bx-user navw__icon'></i>
                            <span class="navw__name">Profile</span>
                        </a>
                    </li>

                    @endrole

                </ul>
            </div>
        </nav>
    </header>
    <div>
        {{ $slot }}
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/backend.js')}}"></script>


    @stack('before-livewire-scripts')
    <livewire:scripts />
    @stack('js')
    @stack('after-livewire-scripts')
    @stack('alpine-plugins')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>

@endrole