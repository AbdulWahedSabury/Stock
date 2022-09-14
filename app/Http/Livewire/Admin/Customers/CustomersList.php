<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CustomersList extends Component
{
    public $search;
    public $customer;
    public $state = [];
    public $editeCustomerState = false;
    public $confirmationCustomerDeleteId;

    public function render()
    {
        $customers = customer::getRecords($this->search);
        return view('livewire.admin.customers.customers-list',
            ['customers' => $customers]
        )->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeCustomerState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
        $customer = Validator::make($this->state, [
            'name' => 'required|string',
            'last_name' => 'nullable|string',
            'phone' => 'required|unique:customers',
        ])->validate();
        customer::create($customer);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Customer added successfully!']);
        return redirect()->back();
    }

    public function edit(customer $customer)
    {
        $this->customer = $customer;
        $this->editeCustomerState = true;
        $this->state = $customer->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $customer = Validator::make($this->state, [
            'name' => 'required|string',
            'last_name' => 'nullable|string',
            'phone' => 'required',
        ])->validate();
        $this->customer->update($customer);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Customer updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationCustomerDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $customer = customer::getRecord($this->confirmationCustomerDeleteId);
        $customer->deleted_at = Carbon::now();
        $customer->save();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'customer Deleted successfully!']);
    }

    public function restore($id)
    {
        $customer = customer::getRecord($id);
        $customer->deleted_at = Null;
        $customer->save();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'customer restored successfully!']);
    }

}
