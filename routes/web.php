<?php


use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Driver;
use App\Http\Livewire\Admin\Transaksi;
use App\Http\Livewire\Driver\Beranda;
use App\Http\Livewire\Driver\Orderan;
use App\Http\Livewire\Layanan\Antrian;
use App\Http\Livewire\Layanan\Charter;
use App\Http\Livewire\Layanan\ChaterBooking;
use App\Http\Livewire\PaymentComponent;
use App\Http\Livewire\Profile\UpdateProfile;
use App\Http\Livewire\Transaksi\Order;
use App\Http\Livewire\Users\ListUsers;


Route::get('/symlink', function () {
    $target = $_SERVER['DOCUMENT_ROOT'] . '/backend-visitor/storage/app/public';
    $link = $_SERVER['DOCUMENT_ROOT'] . '/apps-visitor/storage';
    symlink($target, $link);
    echo "Done";
});

Route::get('/maps', function () {
    return view('map');
})->name('maps');
Route::get('/', function () {
    return view('home');
});

Route::get('home', Antrian::class)->name('home');
Route::get('charter', Charter::class)->name('charter');
Route::get('buy', PaymentComponent::class)->name('buy');
Route::get('/charter/booking/{id}', ChaterBooking::class)->name('charter.booking');

Route::middleware(['auth'])->group(function () {

    Route::get('order', Order::class)->name('order')->middleware(['role:user']);
    Route::get('profile', UpdateProfile::class)->name('profile.edit');

    //Driver routes
    Route::get('beranda', Beranda::class)->name('beranda');
    Route::get('orderan', Orderan::class)->name('orderan');

    //Admin routes
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('driver', Driver::class)->name('driver');
    Route::get('transaksi', Transaksi::class)->name('transaksi');
    Route::get('users', ListUsers::class)->name('users');
});
