<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\Personil;
use App\Models\Taxi\Order as TaxiOrder;
use App\Models\Taxi\UserDriver;
use Livewire\Component;

class Order extends Component
{
    public $idBeingRemoved = null;

    protected $listeners = ['updatedPaymentStatus' => 'updatedPaymentStatus', 'batalbooking' => 'batalbooking'];

    public function updatedPaymentStatus()
    {
        $latestOrder = TaxiOrder::latest()->with(['driver'])->where('user_id', auth()->user()->id)->first();
        $order = $latestOrder;
        $order->status = 'Pembayaran Telah Berhasil!';
        $order->save();
        // Optionally, you can emit a Livewire event to refresh the component or show a success message
        $this->dispatchBrowserEvent('alert', ['message' => 'Pembayaran berhasil! Terima kasih atas pesanan Anda.']);
    }

    public function batalbooking()
    {
        $latestOrder = TaxiOrder::latest()->with(['driver'])->where('user_id', auth()->user()->id)->first();
        $order = $latestOrder;
        $order->update([
            'status' => 'Timeout',
        ]);
        // $user->delete();
        $this->dispatchBrowserEvent('alert', ['message' => 'Booking anda otomatis di batalkan !']);
    }

    public function delete()
    {
        $user = TaxiOrder::findOrFail($this->idBeingRemoved);
        $user->update([
            'status' => 'Batal',
        ]);
        // $user->delete();
        redirect()->route('home');
        $this->reset();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Booking deleted successfully!']);
    }

    public function confirmRemoval($id)
    {
        $this->idBeingRemoved = $id['id'];
        // dd($this->idBeingRemoved);
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function getOrderProperty()
    {
        return TaxiOrder::latest()->with(['driver'])->where('user_id', auth()->user()->id)->first();
    }

    public function getDriverProperty()
    {
        $id = "default";
        if ($this->order) {
            if ($this->order->driver) {
                $id = $this->order->driver->id;
            }
        }
        return UserDriver::with(['user'])->where('id', $id)->first();
    }
    public function getPersonilProperty()
    {
        // Periksa apakah $this->order adalah objek yang valid
        if ($this->order instanceof Order) {
            // Jika $this->order adalah objek Order, dapatkan personil terkait
            return Personil::latest()->where('order_id', $this->order->id)->get();
        }

        // Jika $this->order bukan objek Order, kembalikan null atau koleksi kosong
        return collect(); // Atau return null; tergantung pada kebutuhan Anda
    }
    public function render()
    {
        $snapToken = null;
        $driver = null;
        if ($this->order) {
            $snapToken = $this->order->snap_token;
            if ($this->order->driver) {
                $driver = $this->Driver;
            }
        }
        return view('livewire.transaksi.order', ['personils' => $this->personil, 'order' => $this->order, 'driver' => $driver, 'snapToken' => $snapToken]);
    }
}
