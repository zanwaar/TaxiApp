<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\AppComponent;
use App\Models\Taxi\UserDriver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class Driver extends AppComponent
{
    use WithFileUploads;
    public $state = [];
    public $photo;
    public $photokend;
    public $status = true;
    public $mbarang;
    public $showEditModal = false;
    public $idBeingRemoved = null;
    public $show = false;
    public $showdetail = false;


    public function deleteUser()
    {
        $user = User::findOrFail($this->idBeingRemoved);

        $user->delete();
        $this->reset();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User deleted successfully!']);
    }
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

    public function create()
    {

        Validator::make(
            $this->state,
            [
                'nopolisi' => 'required',
                'no_stnk' => 'required',
                'no_sim' => 'required',
                'jenis_mobil' => 'required',
                'no_tlpn' => 'required|numeric',
                'nama_kepemilikan' => 'required',
                'kapasitas' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ],
        )->validate();
        DB::beginTransaction();
        try {
            $profile = null;
            if ($this->photo) {
                $profile =  $this->photo->store('/', 'avatars');
            }
            $photokendaraan = null;
            if ($this->photokend) {
                $photokendaraan =  $this->photokend->store('/', 'avatars');
            }
            $user = User::create([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'avatar' => $profile,
                'password' => bcrypt($this->state['password']),
            ]);
            $user->assignRole('driver');
            UserDriver::create(
                [
                    'user_id' => $user->id,
                    'fotokend' => $photokendaraan,
                    'nopolisi' => $this->state['nopolisi'],
                    'no_tlpn' => $this->state['no_tlpn'],
                    'no_stnk' => $this->state['no_stnk'],
                    'no_sim' => $this->state['no_sim'],
                    'jenis_mobil' => $this->state['jenis_mobil'],
                    'nama_kepemilikan' => $this->state['nama_kepemilikan'],
                    'kapasitas' => $this->state['kapasitas'],
                    'aktif' => 1,
                ]
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        // dd($this->state); 

        // $this->dispatchBrowserEvent('alert', ['message' => 'Berhasil Ditambahkan Cek lOG Tamu Hari Ini']);
        $this->reset();

        $this->dispatchBrowserEvent('hide-form', ['message' => 'added successfully!']);
    }
    public function edit($par)
    {
        $data = [
            "id" => $par["id"],
            "user_id" => $par["user_id"],
            "fotokend" => $par["fotokend"],
            "nopolisi" => $par["nopolisi"],
            "no_sim" => $par["no_sim"],
            "no_tlpn" => $par["no_tlpn"],
            "no_stnk" => $par["no_stnk"],
            "jenis_mobil" => $par["jenis_mobil"],
            "nama_kepemilikan" => $par["nama_kepemilikan"],
            "kapasitas" => $par["kapasitas"],
            "aktif" => $par["aktif"],
            "name" => $par["user"]["name"],
            "email" => $par["user"]["email"],
            "avatar_url" => $par["user"]["avatar_url"],
        ];

        // dd($user);
        $this->reset();

        $this->showEditModal = true;


        $this->state = $data;
        // dd($this->state);

        $this->dispatchBrowserEvent('show-form');
    }
    public function update()
    {
        $UpdateDetails = User::where('email', $this->state['email'])->first();

        $UpdateDrivers = UserDriver::where('id', $this->state['id'])->first();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        if ($this->photo) {
            Storage::disk('avatars')->delete($UpdateDetails->avatar);
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }

        $profile = $UpdateDetails->avatar;
        if ($this->photo) {
            $profile =  $this->photo->store('/', 'avatars');
        }
        $photokendaraan = $UpdateDrivers->fotokend;
        if ($this->photokend) {
            $photokendaraan =  $this->photokend->store('/', 'avatars');
        }
        Validator::make(
            $this->state,
            [
                'nopolisi' => 'required',
                'no_stnk' => 'required',
                'no_sim' => 'required',
                'jenis_mobil' => 'required',
                'no_tlpn' => 'required|numeric',
                'nama_kepemilikan' => 'required',
                'kapasitas' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' .   $UpdateDetails->id,
                // 'password' => 'sometimes|confirmed',
            ],
        )->validate();
        DB::beginTransaction();
        try {
            $UpdateDetails->update([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'avatar' => $profile,
                // 'password' => bcrypt($this->state['password']),
            ]);
            $UpdateDrivers->update(
                [
                    'user_id' => $UpdateDetails->id,
                    'fotokend' => $photokendaraan,
                    'nopolisi' => $this->state['nopolisi'],
                    'no_stnk' => $this->state['no_stnk'],
                    'no_sim' => $this->state['no_sim'],
                    'no_tlpn' => $this->state['no_tlpn'],
                    'jenis_mobil' => $this->state['jenis_mobil'],
                    'nama_kepemilikan' => $this->state['nama_kepemilikan'],
                    'kapasitas' => $this->state['kapasitas'],
                    'aktif' => $this->state['aktif'],
                ]
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);
    }
    public function getDriverProperty()
    {
        return UserDriver::latest()->with(['user'])->paginate($this->trow);
    }
    public function render()
    {
        // dd($this->driver);
        return view('livewire.admin.driver', ['driver' => $this->driver]);
    }
}
