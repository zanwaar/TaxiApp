<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Taxi\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Midtrans\Config;

class Antrian extends Component
{
    public $state = [];
    public $snapToken;
    public $idpay;
    public $jumlahPenumpang;
    public $totalTarif;

    public function create()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->idpay = uniqid();
        $this->totalTarif = 100000 *  $this->state['jumlah_penumpang'];
        $params = [
            'transaction_details' => [
                'order_id' => $this->idpay,
                'gross_amount' =>  $this->totalTarif, // Ganti dengan jumlah yang sesuai
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => '081234567890',
            ],
            'callbacks' => [
                'finish' => 'http://kilat.fun/buy'
            ],
        ];
        Validator::make(
            $this->state,
            [
                'rute' => 'required',
                'jumlah_penumpang' => 'required|numeric||min:1|max:20',
                'titikkor' => 'required',
                'notlpn' => 'required|numeric',
                'alamat' => 'required',
            ]
        )->validate();
        DB::beginTransaction();
        try {
            $this->snapToken = \Midtrans\Snap::getSnapToken($params);
            Order::create(
                [
                    'user_id' =>  auth()->user()->id,
                    'user_driver_id' => null,
                    'payment_id' => $this->idpay,
                    'rute' => $this->state['rute'],
                    'jumlah_penumpang' => $this->state['jumlah_penumpang'],
                    'titikkor' => $this->state['titikkor'],
                    'notlpn' => $this->state['notlpn'],
                    'alamat' => $this->state['alamat'],
                    'status' => "Menunggu Pembayaran",
                    'layanan' => "Booking",
                    'total_price' =>   $this->totalTarif,
                    'snap_token' =>  $this->snapToken,
                ]
            );

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        $this->emit('booking'); // Emit the 'booking' event
        return redirect()->route('order');
        $this->reset();
        $this->dispatchBrowserEvent('alert', ['message' => 'Booking Lagi Diproses']);
    }

    public function render()
    {
        if (auth()->user() !== null) {
            $data = DB::table('orders')
                ->select('status')
                ->where('user_id', auth()->user()->id)
                ->latest() // Untuk mengambil data terakhir berdasarkan tanggal pembuatan
                ->first();
            if ($data) {
                $status = $data->status;
            } else {
                $status = 'kosong';
            }
        } else {
            $status =  'kosong';
        }
        // dd($status);
        return view('livewire.layanan.antrian', ["status" => $status]);
    }
}
