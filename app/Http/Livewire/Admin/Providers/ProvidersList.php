<?php

namespace App\Http\Livewire\Admin\Providers;

use Livewire\Component;
use App\Models\Provider;
use Illuminate\Support\Facades\Validator;

class ProvidersList extends Component
{
    public $search;
    public $provider;
    public $state = [];
    public $editeProvidersState = false;
    public $confirmationProviderDeleteId;

    public function render()
    {
        $providers = Provider::getRecords($this->search);
        return view('livewire.admin.providers.providers-list',
            ['providers' => $providers]
        )->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeProvidersState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
        $Provider = Validator::make($this->state, [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'responsible' => 'required|string',
            'phone' => 'required|unique:providers',
        ])->validate();
        Provider::create($Provider);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Provider added successfully!']);
        return redirect()->back();
    }

    public function edit(Provider $provider)
    {
        $this->provider = $provider;
        $this->editeProvidersState = true;
        $this->state = $provider->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $provider = Validator::make($this->state, [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'responsible' => 'required|string',
            'phone' => 'required',
        ])->validate();
        $this->provider->update($provider);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Provider updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationProviderDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $provider = Provider::getRecord($this->confirmationProviderDeleteId);
        $provider->delete();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'provider Deleted successfully!']);
    }

}
