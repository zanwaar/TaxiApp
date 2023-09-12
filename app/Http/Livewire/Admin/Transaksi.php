<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\AppComponent;
use App\Models\Taxi\Order;

class Transaksi extends AppComponent
{
    public $state = [];
    public $photo;
    public $photokend;
    public $status = true;
    public $mbarang;
    public $showEditModal = false;
    public $idBeingRemoved = null;
    public $show = false;
    public $showdetail = false;

    protected $listeners = ['booking' => 'refreshComponent'];

    public function getOrderProperty()
    {
        return Order::latest()->with(['user', 'driver'])->paginate($this->trow);
    }

    public function render()
    {
        return view('livewire.admin.transaksi', ['orders' => $this->order]);
    }
    public function refreshComponent()
    {
        $this->render(); // Refresh the component when 'booking' event is received
    }
}
