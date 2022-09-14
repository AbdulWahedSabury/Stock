<?php

namespace App\Http\Livewire\Admin\Sales;

use Exception;
use Throwable;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\customer;
use App\Models\productInventory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class SalesList extends Component
{
    public $search;
    public $sale;
    public $state = [];
    public $selectedInventory;
    public $editeState  = false;
    public $confirmationProductDeleteId;
    public function render()
    {
        $sales = Sale::getRecords();
        $products = productInventory::getRecordsForSale();
        $customers = customer::getRecords();
        $stocks = Stock::getRecords();
        return view('livewire.admin.sales.sales-list',[
                'sales' => $sales,
                'products' => $products,
                'customers' => $customers,
                'stocks' => $stocks,
            ]
        )->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeSaleState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create(Request $request)
    {
        $sale = Validator::make($this->state, [
            'customer_id' => 'required|integer',
            'inventory_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            's_price' => 'required|numeric',
        ])->validate();
        try{
        $this->selectedInventory = productInventory::getRecord($sale['inventory_id']);
        $sale['total_price'] = $sale['quantity'] * $sale['s_price'];
        $this->selectedInventory['quantity'] -= $sale['quantity'];

        Sale::create($sale);
        $this->selectedInventory->update();

        $this->dispatchBrowserEvent('hide-form', ['message' => 'Record added successfully!']);
        return redirect()->back();
        } catch (Throwable $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
    }

    public function edit(Sale $sale)
    {
        $this->sale = $sale;
        $this->editeState  = true;
        $this->state = $sale->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
            $sale = Validator::make($this->state, [
                'customer_id' => 'required|integer',
                'inventory_id' => 'required|numeric',
                'quantity' => 'required|numeric',
                's_price' => 'required|numeric',
            ])->validate();
            $sale['total_price'] = $sale['quantity'] * $sale['s_price'];
            $this->sale->update($sale);
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Sale list updated successfully!']);
            return redirect()->back();

    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $list = Sale::getRecord($this->confirmationDeleteId);
        $list->delete();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
    }
}
