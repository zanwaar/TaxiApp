<?php

namespace App\Http\Livewire;

use App\Models\Taxi\UserDriver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Mitra extends Component
{
    use WithFileUploads;
    public $photokend;
    public $state = [];
    public function create()
    {
        Validator::make(
            $this->state,
            [
                'nopolisi' => 'required',
                'nostnk' => 'required',
                'sim' => 'required',
                'jenismobil' => 'required',
                'notlpn' => 'required|numeric',
                'namakepemilikan' => 'required',
                'kapasitas' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ],
        )->validate();
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'password' => bcrypt($this->state['password']),
            ]);
            $photokendaraan = 'default.png';
            if ($this->photokend) {
                $photokendaraan =  $this->photokend->store('/', 'avatars');
            }
            $count = UserDriver::max('no');
            UserDriver::create(
                [
                    'user_id' => $user->id,
                    'fotokend' => $photokendaraan,
                    'nopolisi' => $this->state['nopolisi'],
                    'no_tlpn' => $this->state['notlpn'],
                    'no_stnk' => $this->state['nostnk'],
                    'no_sim' => $this->state['sim'],
                    'jenis_mobil' => $this->state['jenismobil'],
                    'nama_kepemilikan' => $this->state['namakepemilikan'],
                    'kapasitas' => $this->state['kapasitas'],
                    'aktif' => 0,
                    "no" =>$count + 1,
                ]
            );
            $user->assignRole('driver');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        // $this->reset();
        // redirect()->route('login');
        $this->dispatchBrowserEvent('alert', ['message' => 'Booking Lagi Diproses']);
    }
}
