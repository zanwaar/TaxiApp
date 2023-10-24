<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\AppComponent;
use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use Illuminate\Support\Facades\DB;

class Transaksi extends AppComponent
{

    public $drivers = false;
    public $idorder;
    public $iddriver;
    public $jml;
    public $filter = 'today';

    protected $listeners = ['booking' => 'refreshComponent'];

    public function filter($filter)
    {
        $this->filter = $filter;
    }
    public function getOrderProperty()
    {
        $query = Order::latest()->with(['user', 'driver']);

        if ($this->filter === 'today') {
            $query->where('date', now()->toDateString());
        }

        return $query->paginate($this->trow);
    }
    public function confirm($id)
    {
        $this->drivers = true;
        $this->idorder = $id["id"];
        $this->jml = $id["jumlah_penumpang"];
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function confirmRemoval($bg)
    {
        $this->iddriver = $bg["id"];
        $update_order = Order::findOrFail($this->idorder);
        $update_driver = UserDriver::findOrFail($this->iddriver);

        // Periksa apakah $bg["order"] dan $bg["kapasitas"] ada dan bukan null
        $total_penumpang = isset($bg["order"]["total_penumpang"]) ? intval($bg["order"]["total_penumpang"]) : 0;
        $kapasitas = isset($bg["kapasitas"]) ? intval($bg["kapasitas"]) : 0;

        // Hitung total
        $total = intval($update_driver->kapasitas) - $total_penumpang ?? $kapasitas;

        $jumlah_penumpang = intval($update_order->jumlah_penumpang);

        if ($jumlah_penumpang > $total) {
            return $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Gagal Cek Kuota LAGI']);
        }

        $update_order->update([
            'user_driver_id' => $this->iddriver,
        ]);
        $update_driver->update([
            'transaksi' => 1,
        ]);

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'successfully!']);
    }
    public function getDriverProperty()
    {
        return UserDriver::with(['order' => function ($query) {
            $query->select('user_driver_id', DB::raw('sum(jumlah_penumpang) as total_penumpang'))
                ->where('status', '!=', 'selesai')
                ->groupBy('user_driver_id');
        }])->where('aktif', '!=', 2)->orderBy('no', 'asc')->get();
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
