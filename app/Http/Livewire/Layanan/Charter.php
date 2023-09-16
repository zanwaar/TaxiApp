<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
 
class Charter extends Component
{
    public function getDriverProperty()
    {
        return UserDriver::latest()->with(['user'])->where('aktif', '!=', '2')->get();
    }
    public function render()
    {
        if (auth()->user() !== null) {
            $data = DB::table('orders')
            ->select('status')
            ->where('user_id', auth()->user()->id)
                ->latest() // Untuk mengambil data terakhir berdasarkan tanggal pembuatan
                ->first();
            $status = $data->status;
        } else {
            $status =  null;
        }
        return view('livewire.layanan.charter', ['driver' => $this->driver, 'status' => $status]);
    }
}
