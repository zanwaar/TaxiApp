<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Rating;
use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Charter extends Component
{
    public function getDriverProperty()
    {
        return UserDriver::latest()->with(['user'])
            ->where('aktif', '!=', '2')
            ->where('transaksi', 0)
            ->get();
    }
    public function render()
    {
        $status =  null;
        if (auth()->user() !== null) {
            $data = DB::table('orders')
                ->select('status')
                ->where('user_id', auth()->user()->id)
                ->latest() // Untuk mengambil data terakhir berdasarkan tanggal pembuatan
                ->first();
            if ($data == null) {
                $status =  null;
            } else {
                $status = $data->status;
            }
        }

        return view('livewire.layanan.charter', ['driver' => $this->driver, 'status' => $status]);
    }
}
