<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Taxi\UserDriver;
use Livewire\Component;

class Charter extends Component
{
    public function getDriverProperty()
    {
        return UserDriver::latest()->with(['user'])->get();
    }
    public function render()
    {
        return view('livewire.layanan.charter', ['driver' => $this->driver]);
    }
}
