<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Midtrans\Config;

class ChaterBooking extends Component
{
    public $parameter;
    public $state = [];
    public $snapToken;
    public $idpay;
    public function mount($id)
    {
        $this->parameter = $id;
    }
    public function create()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->idpay = uniqid();
        $params = [
            'transaction_details' => [
                'order_id' => $this->idpay,
                'gross_amount' => 10000, // Ganti dengan jumlah yang sesuai
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
                'jumlah_penumpang' => 'required|numeric|max:20',
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
                    'user_driver_id' => $this->parameter,
                    'payment_id' => $this->idpay,
                    'rute' => $this->state['rute'],
                    'jumlah_penumpang' => $this->state['jumlah_penumpang'],
                    'titikkor' => $this->state['titikkor'],
                    'notlpn' => $this->state['notlpn'],
                    'alamat' => $this->state['alamat'],
                    'status' => "Menunggu Pembayaran",
                    'layanan' => "Charter Mobil",
                    'total_price' => 10000,
                    'snap_token' =>  $this->snapToken,
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
    public function getDriverProperty()
    {
        return UserDriver::with(['user'])->where('id', $this->parameter)->first();
    }
    public function render()
    {
        if (auth()->user() !== null) {
            $status = DB::table('orders')
                ->select('status')
                ->where('user_id', auth()->user()->id)
                ->first();
        } else {
            $status =  null;
        }
        return view('livewire.layanan.chater-booking', ['driver' => $this->driver, 'status' => $status]);
    }
}
