<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ActivityLog\ActivityLog;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Driver;
use App\Http\Livewire\Admin\Transaksi;
use App\Http\Livewire\Bagian\ListBagian;
use App\Http\Livewire\Barang\ListBarang;
use App\Http\Livewire\Layanan\Antrian;
use App\Http\Livewire\Layanan\Charter;
use App\Http\Livewire\Magang\ListMagang;
use App\Http\Livewire\Profile\UpdateProfile;
use App\Http\Livewire\Settings\UpdateSetting;
use App\Http\Livewire\Tamu\CreateTamu;
use App\Http\Livewire\Tamu\ListTamu;
use App\Http\Livewire\Tamu\LogTamu;
use App\Http\Livewire\Transaksi\Order;
use App\Http\Livewire\Users\ListUsers;
use App\Http\Livewire\Workingpermit\CreateWorkingPermit;
use App\Http\Livewire\Workingpermit\DetailWorkingPermit;
use App\Http\Livewire\Workingpermit\EditWorkingPermit;
use App\Http\Livewire\Workingpermit\ListWorkingPermit;

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
// Route::get('/', Atrian::class);
Route::get('home', Antrian::class)->name('home');
Route::get('charter', Charter::class)->name('charter');

Route::middleware(['auth'])->group(function () {

    Route::get('transaksi', Transaksi::class)->name('transaksi');
    Route::get('order', Order::class)->name('order');

    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('driver', Driver::class)->name('driver');
    Route::get('profile', UpdateProfile::class)->name('profile.edit');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/', DashboardController::class);
//     Route::get('dashboard', DashboardController::class)->name('dashboard');
//     Route::get('bukuTamu', LogTamu::class)->name('tamu');
//     Route::get('daftarTamu', ListTamu::class)->name('daftartamu');
//     Route::get('tambahTamu', CreateTamu::class)->name('tambahtamu');
//     Route::get('listMagang', ListMagang::class)->name('listmagang');
//     Route::get('listbarang', ListBarang::class)->name('listbarang');
//     Route::get('bagian', ListBagian::class)->name('bagian');
//     Route::get('activity', ActivityLog::class)->name('activity')->middleware('role:admin');
//     Route::get('listworking', ListWorkingPermit::class)->name('listworking');
//     Route::get('createworking', CreateWorkingPermit::class)->name('createworking')->middleware('role:admin');
//     Route::get('detailworking/{workingpermit}/Detail', DetailWorkingPermit::class)->name('detailworking.detail');
//     Route::get('editworking/{workingpermit}', EditWorkingPermit::class)->name('editworking')->middleware('role:admin');

//     Route::get('settings', UpdateSetting::class)->name('settings')->middleware('role:admin');
Route::get('users', ListUsers::class)->name('users');
// });
