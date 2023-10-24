<?php

namespace App\Http\Livewire\Driver;

use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Orderan extends Component
{
    public $idorderfield;
    public $konf;
    public function refreshPage()
    {
        // Fungsi ini akan merefresh halaman
        $this->emit('refreshPage');
    }
    public function getDriverProperty()
    {
        return UserDriver::where('user_id',  auth()->user()->id)->first();
    }
    public function getOrderProperty()
    {
        return Order::latest()->with(['user', 'driver'])
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'Batal')
            ->where('user_driver_id', $this->driver->id)->get();
    }
    public function confirmRemoval($id)
    {
        // dd($id);
        $this->idorderfield = $id["id"];
        $this->konf = true;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function confirm($id)
    {
        // dd($id);
        $this->idorderfield = $id["id"];
        $this->konf = false;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function konfirmasi()
    {


        if ($this->konf) {
            $order = Order::findOrFail($this->idorderfield);
            $driver = UserDriver::where('id', $order->user_driver_id)->first();
            $count = UserDriver::sum('no');
            DB::beginTransaction();
            try {

                $count = UserDriver::max('no');
                $order->update([
                    'status' => 'selesai',
                ]);
                $statusArray = [];
                foreach ($this->order as $key => $value) {

                    if ($value->status == 'Terima') {
                        $statusArray[$key] = $value->status;
                    }
                }
                if (count($statusArray) == 0) {
                    $driver->update([
                        'aktif' => 1,
                        'no' => $count + 1,
                    ]);
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
            $this->reset();
            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Orderan Telah di selesaikan!']);
        } else {
            $order = Order::findOrFail($this->idorderfield);
            $driver = UserDriver::where('id', $order->user_driver_id)->first();
            DB::beginTransaction();
            try {
                $order->update([
                    'status' => 'Terima',
                ]);
                $driver->update([
                    'aktif' => 2,
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
            $this->reset();
            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Orderan Telah di Terima']);
        }
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
