<?php

namespace App\Http\Livewire\Admin\Users;

use Hash;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\withFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersLists extends Component
{
    use withFileUploads;
    public $state = [];
    public $user;
    public $editeUserState = false;
    public $confirmationUserDeleteId;
    public $searchTerm = null;
    public $photo;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $users = User::query()
        ->where('name', 'like', '%' . $this->searchTerm . '%')
        ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
        ->latest()->paginate(5);
        return view('livewire.admin.users.users-lists', compact('users'))
            ->layout('admin.layouts.app');;
    }

    public function AddNewUser()
    {
        $this->reset();
        $this->editeUserState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createNewUser()
    {
        $data = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ])->validate();
        $data['password'] = Hash::make($data['password']);
        if ($this->photo) {
            $data['avatar'] = $this->photo->store('/', 'avatars');
        }
        User::create($data);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added successfully!']);
        return redirect()->back();
    }

    public function editUser(User $user)
    {
        $this->user = $user;
        $this->editeUserState = true;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function SaveUsersChanges()
    {
        $data = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'sometimes|confirmed',
        ])->validate();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if ($this->photo) {
            Storage::disk('avatars')->delete($this->user->avatar);
            $data['avatar'] = $this->photo->store('/', 'avatars');
        }
        $this->user->update($data);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);
    }

    public function ConfirmationUserDelete($userId)
    {
        $this->confirmationUserDeleteId = $userId;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function DeleteUser()
    {
        $userToDelete = User::getRecord($this->confirmationUserDeleteId);
        $userToDelete->delete();
        $this->dispatchBrowserEvent('hide-delete-form', ['message' => 'User Deleted successfully!']);
    }

}
