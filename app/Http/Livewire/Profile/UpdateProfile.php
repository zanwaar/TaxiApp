<?php

namespace App\Http\Livewire\Profile;

use App\Models\Taxi\UserDriver;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Spatie\Activitylog\Models\Activity;
use Request as Requestip;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;
    public $photokend;
    public $state = [];
    public $drivers = [];

    public function mount()
    {
        $this->state = auth()->user()->only(['name', 'email']);
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image', // 1MB Max
        ]);

        $previousPath = auth()->user()->avatar;
        $path = $this->image->store('/', 'avatars');
        auth()->user()->update(['avatar' => $path]);
        Storage::disk('avatars')->delete($previousPath);

        activity()
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->tap(function (Activity $activity) {
                $activity->ip = Requestip::ip();
                $activity->log_name = 'user';
            })
            ->log(auth()->user()->name . ' Ganti Foto Profile');
        $lastLoggedActivity = Activity::all()->last();
        $lastLoggedActivity->log_name;
        $lastLoggedActivity->subject;
        $lastLoggedActivity->causer;
        $lastLoggedActivity->description;
        $lastLoggedActivity->ip;
        $this->dispatchBrowserEvent('alert', ['message' => 'Profile changed successfully!']);
    }
    public function update_kendaraan()

    {

        $photokendaraan = $this->driver->fotokend;
        if ($this->photokend) {
            $photokendaraan =  $this->photokend->store('/', 'avatars');
        }
        Validator::make(
            $this->drivers,
            [
                'nopolisi' => 'required',
                'no_stnk' => 'required',
                'no_sim' => 'required',
                'jenis_mobil' => 'required',
                'no_tlpn' => 'required|numeric',
                'nama_kepemilikan' => 'required',
                'kapasitas' => 'required|numeric',
            ],
        )->validate();
        DB::beginTransaction();
        try {

            $this->driver->update(
                [
                    'fotokend' => $photokendaraan,
                    'nopolisi' => $this->drivers['nopolisi'],
                    'no_stnk' => $this->drivers['no_stnk'],
                    'no_sim' => $this->drivers['no_sim'],
                    'no_tlpn' => $this->drivers['no_tlpn'],
                    'jenis_mobil' => $this->drivers['jenis_mobil'],
                    'nama_kepemilikan' => $this->drivers['nama_kepemilikan'],
                    'kapasitas' => $this->drivers['kapasitas'],
                ]
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        $this->dispatchBrowserEvent('hide-form', ['message' => 'updated successfully!']);
    }
    public function updateProfile(UpdatesUserProfileInformation $updater)
    {
        $updater->update(auth()->user(), [
            'name' => $this->state['name'],
            'email' => $this->state['email']
        ]);

        if (!empty($this->driver)) {
            $this->driver->update(
                [
                    'no_tlpn' => $this->drivers['no_tlpn'],
                ]
            );
        }

        $this->emit('nameChanged', auth()->user()->name);

        activity()
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->tap(function (Activity $activity) {
                $activity->ip = Requestip::ip();
                $activity->log_name = 'user';
            })
            ->log(auth()->user()->name . ' Melakukan Update Profile');
        $lastLoggedActivity = Activity::all()->last();

        $lastLoggedActivity->log_name;
        $lastLoggedActivity->subject;
        $lastLoggedActivity->causer;
        $lastLoggedActivity->description;
        $lastLoggedActivity->ip;

        $this->dispatchBrowserEvent('alert', ['message' => 'Profile updated successfully!']);
    }

    public function changePassword(UpdatesUserPasswords $updater)
    {
        $updater->update(
            auth()->user(),
            $attributes = Arr::only($this->state, ['current_password', 'password', 'password_confirmation'])
        );

        collect($attributes)->map(fn ($value, $key) => $this->state[$key] = '');


        activity()
            ->performedOn(auth()->user())
            ->causedBy(auth()->user())
            ->tap(function (Activity $activity) {
                $activity->ip = Requestip::ip();
                $activity->log_name = 'user';
            })
            ->log(auth()->user()->name . ' Melakukan Ganti Password');
        $lastLoggedActivity = Activity::all()->last();

        $lastLoggedActivity->log_name;
        $lastLoggedActivity->subject;
        $lastLoggedActivity->causer;
        $lastLoggedActivity->description;
        $lastLoggedActivity->ip;
        $this->dispatchBrowserEvent('alert', ['message' => 'Password changed successfully!']);
    }
    public function getDriverProperty()
    {
        return UserDriver::where('user_id', auth()->user()->id)->first();
    }
    public function render()
    {
        if (!empty($this->driver)) {
            $data = [
                "nopolisi" => $this->driver->nopolisi,
                "kapasitas" => $this->driver->kapasitas,
                "no_stnk" => $this->driver->no_stnk,
                "no_sim" => $this->driver->no_sim,
                "jenis_mobil" => $this->driver->jenis_mobil,
                "nama_kepemilikan" => $this->driver->nama_kepemilikan,
                "fotokend" => $this->driver->fotokend,
                "no_tlpn" => $this->driver->no_tlpn,
            ];
            $this->drivers = $data;
        }
        return view('livewire.profile.update-profile');
    }
}
