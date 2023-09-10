<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Taxi\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Antrian extends Component
{
    public $state = [];
    public function create()
    {
        Validator::make(
            $this->state,
            [
                'rute' => 'required',
                'jumlah_penumpang' => 'required|numeric|max:20',
                'titikkor' => 'required',
                'notlpn' => 'required|numeric',
                'alamat' => 'required',
            ]
        )->validate();
        DB::beginTransaction();
        try {

            Order::create(
                [
                    'user_id' =>  auth()->user()->id,
                    'user_driver_id' => null,
                    'rute' => $this->state['rute'],
                    'jumlah_penumpang' => $this->state['jumlah_penumpang'],
                    'titikkor' => $this->state['titikkor'],
                    'notlpn' => $this->state['notlpn'],
                    'alamat' => $this->state['alamat'],
                    'status' => "Menunggu Pembayaran",
                    'layanan' => "Booking",
                ]
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        redirect()->route('order');
        $this->reset();
        $this->dispatchBrowserEvent('alert', ['message' => 'Booking Lagi Diproses']);
    }
    public function render()
    {
        if (auth()->user() !== null) {
            $status = DB::table('orders')
                ->select('status')
                ->where('user_id', auth()->user()->id)
                ->where('status', 'Menunggu Pembayaran')
                ->first();
        } else {
            $status =  null;
        }
        return view('livewire.layanan.antrian', ["status" => $status]);
    }
}
