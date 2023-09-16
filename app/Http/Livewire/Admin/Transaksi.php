<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\AppComponent;
use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;

class Transaksi extends AppComponent
{

    public $drivers = false;
    public $idorder;
    public $iddriver;

    protected $listeners = ['booking' => 'refreshComponent'];

    public function getOrderProperty()
    {
        return Order::latest()->with(['user', 'driver'])->paginate($this->trow);
    }

    public function confirm($id)
    {
        $this->drivers = true;
        $this->idorder = $id["id"];
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function confirmRemoval($bg)
    {
        $this->iddriver = $bg["id"];
        $update_order = Order::findOrFail($this->idorder);
        $update_driver = UserDriver::findOrFail($this->iddriver);

        $update_order->update([
            'user_driver_id' => $this->iddriver,
        ]);
        // $update_driver->update([
        //     'aktif' => 2,
        // ]);
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'successfully!']);
    }
    public function getDriverProperty()
    {
        return UserDriver::latest()->where('aktif', '!=', 2)->get();
    }
    public function render()
    {
        if ($this->drivers) {
            $data = $this->driver;
        } else {
            $data = null;
        }
        return view('livewire.admin.transaksi', ['orders' => $this->order, 'data' => $data]);
    }
    public function refreshComponent()
    {
        $this->render(); // Refresh the component when 'booking' event is received
    }
}
