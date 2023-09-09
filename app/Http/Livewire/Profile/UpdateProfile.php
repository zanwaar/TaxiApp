<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Spatie\Activitylog\Models\Activity;
use Request as Requestip;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;

    public $state = [];

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

    public function updateProfile(UpdatesUserProfileInformation $updater)
    {
        $updater->update(auth()->user(), [
            'name' => $this->state['name'],
            'email' => $this->state['email']
        ]); 

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

    public function render()
    {
        return view('livewire.profile.update-profile');
    }
}
