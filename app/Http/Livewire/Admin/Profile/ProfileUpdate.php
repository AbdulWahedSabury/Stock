<?php

namespace App\Http\Livewire\Admin\Profile;

use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class ProfileUpdate extends Component
{
    use WithFileUploads;
    public $image;
    public $state = [];

    public function render()
    {
        return view('livewire.admin.profile.profile-update')->layout('admin.layouts.app');
    }

    public function mount()
    {
        $this->state = auth()->user()->only(['name', 'email']);
    }

    public function updatedImage()
    {
        $previousPath = auth()->user()->avatar;
        $path = $this->image->store('/', 'avatars');
        auth()->user()->update(['avatar' => $path]);
        Storage::disk('avatars')->delete($previousPath);
        $this->dispatchBrowserEvent('changed', ['message' => 'Profile changed successfully!']);
    }

    public function updateProfile(UpdatesUserProfileInformation $updater)
    {
        $updater->update(auth()->user(), [
            'name' => $this->state['name'],
            'email' => $this->state['email']
        ]);
        $this->emit('nameChanged', auth()->user()->name);
        $this->dispatchBrowserEvent('changed', ['message' => 'Profile updated successfully!']);
    }

    public function changePassword(UpdatesUserPasswords $updater)
    {
        $updater->update(
            auth()->user(),
            $attributes = Arr::only($this->state, ['current_password', 'password', 'password_confirmation'])
        );
        collect($attributes)->map(fn ($value, $key) => $this->state[$key] = '');
        $this->dispatchBrowserEvent('changed', ['message' => 'Password changed successfully!']);
    }


}
