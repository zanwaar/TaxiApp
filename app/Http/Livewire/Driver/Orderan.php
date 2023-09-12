<?php

namespace App\Http\Livewire\Driver;

use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Orderan extends Component
{
    public $idorderfield;
    public function getDriverProperty()
    {
        return UserDriver::where('user_id',  auth()->user()->id)->first();
    }
    public function getOrderProperty()
    {
        return Order::latest()->with(['user', 'driver'])
            ->where('status', '!=', 'selesai')
            ->where('user_driver_id', $this->driver->id)->get();
    }
    public function confirmRemoval($id)
    {
        $this->idorderfield = $id["id"];

        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function konfirmasi()
    {
        $order = Order::findOrFail($this->idorderfield);
        $driver = UserDriver::where('id', $order->user_driver_id)->first();
        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'selesai',
            ]);
            $driver->update([
                'aktif' => 1,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Orderan Telah di selesaikan!']);
    }
    public function render()
    {

        if (count($this->order) == 0) {
            $orders = null;
        } else {
            $orders = $this->order;
        }

        return view('livewire.driver.orderan', ['order' => $orders]);
    }
}
