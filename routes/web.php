<?php


use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Driver;
use App\Http\Livewire\Admin\Transaksi;
use App\Http\Livewire\Driver\Beranda;
use App\Http\Livewire\Driver\Orderan;
use App\Http\Livewire\Driver\Transaksi as DriverTransaksi;
use App\Http\Livewire\Layanan\Antrian;
use App\Http\Livewire\Layanan\Charter;
use App\Http\Livewire\Layanan\ChaterBooking;
use App\Http\Livewire\PaymentComponent;
use App\Http\Livewire\Profile\UpdateProfile;
use App\Http\Livewire\Transaksi\History;
use App\Http\Livewire\Transaksi\Order;
use App\Http\Livewire\Users\ListUsers;
use App\Models\Taxi\UserDriver;

Route::get('/symlink', function () {
    $target = $_SERVER['DOCUMENT_ROOT'] . '/backend-app/storage/app/public';
    $link = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($target, $link);
    echo "Done";
});

Route::get('/maps', function () {
    return view('map');
})->name('maps');

Route::get('/mitra', function () {
    return view('auth/mitra');
})->name('mitra')->middleware('guest');


Route::get('/', function () {
    $driver = UserDriver::latest()->with(['user'])->where('aktif', '!=', '2')->get();
    return view('landingpage', ['drivers' => $driver]);
})->name('landingpage')->middleware('guest');



Route::middleware(['auth'])->group(function () {
    Route::get('/app', function () {
        return view('home');
    })->name('app');
    //User routes
    Route::get('home', Antrian::class)->name('home')->middleware(['role:user']);
    Route::get('charter', Charter::class)->name('charter')->middleware(['role:user']);
    Route::get('buy', PaymentComponent::class)->name('buy')->middleware(['role:user']);
    Route::get('/charter/booking/{id}', ChaterBooking::class)->name('charter.booking')->middleware(['role:user']);
    Route::get('order', Order::class)->name('order')->middleware(['role:user']);
    Route::get('history', History::class)->name('history')->middleware(['role:user']);


    Route::get('profile', UpdateProfile::class)->name('profile.edit');

    //Driver routes
    Route::get('beranda', Beranda::class)->name('beranda');
    Route::get('orderan', Orderan::class)->name('orderan');
    Route::get('dtransaksi', DriverTransaksi::class)->name('dtransaksi');

    //Admin routes
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('driver', Driver::class)->name('driver');
    Route::get('transaksi', Transaksi::class)->name('transaksi');
    Route::get('users', ListUsers::class)->name('users');
});
