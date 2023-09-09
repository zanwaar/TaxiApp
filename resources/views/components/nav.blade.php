<div class="navw__menu" id="navw-menu">
    <ul class="navw__list" style="padding-left: 0px !important;  margin-bottom: 0px !important;">
        <li class="navw__item">
            <a href="{{ route('home') }}" class="navw__link {{ request()->is('charter') | request()->is('home') | request()->is('/') ? 'active-link' : '' }}">
                <i class='bx bx-home-alt navw__icon'></i>
                <span class=" navw__name">Beranda</span>
            </a>
        </li>
        <li class="navw__item ">
            <a href="{{ route('order') }}" class="navw__link {{ request()->is('order') ? 'active-link' : '' }}">
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
    </ul>
</div>