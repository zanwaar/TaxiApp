<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\Taxi\Order as TaxiOrder;
use Livewire\Component;

class Order extends Component
{
    public $idBeingRemoved = null;

    public function delete()
    {
        $user = TaxiOrder::findOrFail($this->idBeingRemoved);

        $user->delete();
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
        return TaxiOrder::latest()->with(['driver'])->first();
    }
    public function render()
    {
        return view('livewire.transaksi.order', ['order' => $this->order]);
    }
}
