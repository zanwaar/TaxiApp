<?php

namespace App\Http\Livewire\Layanan;

use App\Models\Personil;
use App\Models\Taxi\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Midtrans\Config;
use Carbon\Carbon;

class Antrian extends Component
{
    public $bookingDate;
    public $state = [];
    public $snapToken;
    public $idpay;
    public $jumlahPenumpang;
    public $totalTarif;
    public $data = true;
    public $check = true;
    public $inputs = [];
    public $nama = [];
    public $i = 1;
    public function mount()
    {
        $this->state['jumlahpenumpang'] = 1;
    }
    public function add($i)
    {
        if (count($this->inputs) < 7) {
            $i = $i + 1;
            $this->i = $i;
            $this->state['jumlahpenumpang'] = $i;
            array_push($this->inputs, $i);
        }
    }
    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
        $this->i = count($this->inputs) + 1; // Mengupdate nilai i dengan jumlah elemen baru
        $this->state['jumlahpenumpang'] = count($this->inputs) + 1;
    }
    private function resetInputFields()
    {

        $this->nama = '';
        $this->inputs = [];
    }
    public function toggleData()
    {
        $this->data = !$this->data;
        $this->bookingDate = null;
    }

    public function create()
    {

        $parsedDate = Carbon::parse($this->bookingDate)->setTime(Carbon::now()->format('H'), Carbon::now()->format('i'), Carbon::now()->format('s'));
        if ($this->bookingDate) {
            $waktuSaatIni = $parsedDate->format('Y-m-d');
        } else {
            $waktuSaatIni = Carbon::now();
        }
        Validator::make(
            $this->state,
            [
                'rute' => 'required',
                'jumlahpenumpang' => 'required|numeric||min:1|max:8',
                'titikkor' => 'required',
                'notlpn' => 'required|numeric',
                'alamat' => 'required',
            ]
        )->validate();
        $this->validate([
            'nama.1' => 'required',
        ]);
        foreach ($this->inputs as $key => $value) {
            $r = $value;
            $this->validate([
                'nama.' . $r => 'required',
            ]);
        }
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->idpay = uniqid();
        $this->totalTarif = 100000 * $this->i;
        $params = [
            'transaction_details' => [
                'order_id' => $this->idpay,
                'gross_amount' =>  $this->totalTarif, // Ganti dengan jumlah yang sesuai
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => $this->state['notlpn'],
            ],
            'callbacks' => [
                'finish' => 'http://kilat.fun/buy'
            ],
        ];

        DB::beginTransaction();
        try {
            $this->snapToken = \Midtrans\Snap::getSnapToken($params);
            $order = Order::create(
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
                    'date' => $waktuSaatIni
                ]
            );
            foreach ($this->nama as $key => $value) {
                Personil::create(['nama' => $this->nama[$key], 'order_id' => $order->id]);
            }
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

    public function cekStatusdate()
    {
        $waktuSaatIni = Carbon::now();
        $waktuBuka = Carbon::createFromTime(6, 0, 0); // Mengatur waktu buka pada pukul 06:00
        $waktuTutup = Carbon::createFromTime(13, 0, 0); // Mengatur waktu tutup pada pukul 13:00

        if ($waktuSaatIni->between($waktuBuka, $waktuTutup)) {
            return "opened";
        } else {
            return "closed.";
        }
    }
    public function cekdate()
    {
        $waktuSaatIni = Carbon::now();
        $waktuBuka = Carbon::createFromTime(6, 0, 0); // Mengatur waktu buka pada pukul 06:00
        $waktuTutup = Carbon::createFromTime(13, 0, 0); // Mengatur waktu tutup pada pukul 13:00

        if ($waktuSaatIni->between($waktuBuka, $waktuTutup)) {
            return  $this->check = true;
        } else {
            return  $this->check = false;
        }
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
        $statusdate = $this->cekStatusdate();

        return view('livewire.layanan.antrian', ["status" => $status, "statusdate" => $statusdate, 'cekdate' => $this->cekdate()]);
    }
}
