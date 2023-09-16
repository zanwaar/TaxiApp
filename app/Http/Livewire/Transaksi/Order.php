<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\Taxi\Order as TaxiOrder;
use App\Models\Taxi\UserDriver;
use Livewire\Component;

class Order extends Component
{
    public $idBeingRemoved = null;


    protected $listeners = ['updatedPaymentStatus' => 'updatedPaymentStatus'];

    public function updatedPaymentStatus()
    {
        $latestOrder = TaxiOrder::latest()->with(['driver'])->where('user_id', auth()->user()->id)->first();
        $order = $latestOrder;
        $order->status = 'Pembayaran Telah Berhasil!';
        $order->save();
        // Optionally, you can emit a Livewire event to refresh the component or show a success message
        $this->dispatchBrowserEvent('alert', ['message' => 'Pembayaran berhasil! Terima kasih atas pesanan Anda.']);
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
        return view('livewire.transaksi.order', ['order' => $this->order, 'driver' => $driver, 'snapToken' => $snapToken]);
    }
}
