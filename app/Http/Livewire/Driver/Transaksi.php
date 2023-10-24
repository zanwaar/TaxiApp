<?php

namespace App\Http\Livewire\Driver;

use App\Http\Livewire\AppComponent;
use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Livewire\Component;

class Transaksi extends AppComponent
{
    public function getOrderProperty()
    {
        $driver = UserDriver::where('user_id',  auth()->user()->id)->first();
        return Order::latest()->with(['user', 'driver', 'rating'])
            ->where('status', 'selesai')
            ->where('user_driver_id', $driver->id)->paginate(2);
    }
    public function render()
    {
        // dd($this->order);
        return view('livewire.driver.transaksi', ['order' => $this->order]);
    }
}
