<?php

namespace App\Http\Livewire;

use App\Models\Taxi\Order;
use Livewire\Component;
use Illuminate\Http\Request;

class PaymentComponent extends Component
{

    public $order_id;
    public $status_code;
    public $transaction_status;

    public function mount(Request $request)
    {
        $latestOrder = Order::latest()->with(['driver'])->where('user_id', auth()->user()->id)->first();
        $order = $latestOrder;
        $order->status = 'Aktif';
        $order->save();
        $this->dispatchBrowserEvent('alert', ['message' => 'Pembayaran Telah Diterima']);
        redirect()->route('order');
    }
    public function render()
    {
        return view('livewire.payment-component');
    }
}
