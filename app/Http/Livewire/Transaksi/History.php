<?php

namespace App\Http\Livewire\Transaksi;

use App\Http\Livewire\AppComponent;
use App\Models\Rating;
use App\Models\Taxi\Order;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class History extends AppComponent
{
    public $state = [];
    public $iddriver;
    public $idorder;
    public $idrating;
    public $rs = 0;
    public $comment;
    public $currentId;
    public $product;
    public $showEditModal;
    public $idBeingRemoved;

    public function confirmRemoval($user)
    {
        $this->idBeingRemoved = $user['id'];
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function addNew()
    {
        $this->reset();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function setRating($rating)
    {
        $this->rs = $rating;
        $this->state['rating'] = $rating;
        // Kirim event Livewire ke JavaScript
        $this->dispatchBrowserEvent('ratingUpdated', ['rating' => $this->rs]);

        // Set rating di sini sesuai kebutuhan aplikasi Anda
        // Misalnya, simpan rating ke database atau lakukan tindakan lainnya
    }
    public function uls($par)
    {
        $this->showEditModal = true;
        $this->idrating = $par["ratings_id"];
        $this->iddriver = $par["driver"]["id"];
        $this->idorder = $par["id"];

        $rs = Rating::where('id', $this->idrating)->first();
        if (!empty($rs)) {

            $data = [
                "rating" => strval($rs["rating"]),
                "comment" => $rs["comment"],
            ];
            $this->state = $data;
            $this->rs = strval($rs["rating"]);
        }
        $this->dispatchBrowserEvent('show-form');
    }
    public function close()
    {
        $this->reset();
        $this->dispatchBrowserEvent('hide-form-tanpa-tos');
    }
    public function rate()
    {
        // dd($this->state);
        $rs = Rating::where('id', $this->idrating)->first();
        // $this->validate();
        Validator::make(
            $this->state,
            [
                'rating' => ['required', 'in:1,2,3,4,5'],
                'comment' => 'required',
            ]
        )->validate();
        if (!empty($rs)) {
            $rs->user_id = auth()->user()->id;
            $rs->user_driver_id = $this->iddriver;
            $rs->rating = $this->rs;
            $rs->comment = $this->state['comment'];
            $rs->status = 1;
            try {
                $rs->update();
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            $Updateorder = Order::where('id', $this->idorder)->first();

            $rs = new Rating();
            $rs->user_id = auth()->user()->id;
            $rs->user_driver_id = $this->iddriver;
            $rs->rating = $this->rs;
            $rs->comment = $this->state['comment'];
            $rs->status = 1;
            try {
                $rs->save();
                $Updateorder->update([
                    'ratings_id' => $rs->id,
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        $this->reset();
        $this->dispatchBrowserEvent('hide-form', ['message' => 'successfully!']);
    }
    public function getOrderProperty()
    {
        return Order::latest()->with(['driver'])
            ->where('user_id', auth()->user()->id)
            ->where('status', 'selesai')->paginate(10);
    }
    public function render()
    {
        // dd($this->order);
        return view('livewire.transaksi.history', ['orders' => $this->order]);
    }
}
