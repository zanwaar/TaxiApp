<?php

namespace App\Http\Livewire\Driver;

use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Livewire\Component;

class Beranda extends Component
{

    public function getDriverProperty()
    {
        return UserDriver::where('user_id',  auth()->user()->id)->first();
    }
    public function getOrderProperty()
    {
        return Order::latest()->with(['user', 'driver'])->where('user_driver_id', $this->driver->id)->get();
    }

    public function render()
    {
        dd($this->order);
        return view('livewire.driver.beranda', ['driver' => $this->order]);
    }
}
