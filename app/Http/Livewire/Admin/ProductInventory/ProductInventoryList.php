<?php

namespace App\Http\Livewire\Admin\ProductInventory;

use Throwable;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\productInventory;
use Illuminate\Support\Facades\Validator;

class ProductInventoryList extends Component
{
    public $search;
    public $inventory;
    public $state = [];
    public $editeState = false;
    public $productValidInventory;
    public $confirmationDeleteId;
    public $selectedProduct;
    public function render()
    {
        $stocks = Stock::getRecords();
        $products = Product::getRecords();
        $inventories = productInventory::getRecords($this->state);
        return view('livewire.admin.product-inventory.product-inventory-list',
        ['inventories' => $inventories,
        'stocks' => $stocks,
        'products' => $products])->layout('admin.layouts.app');
    }
    public function add()
    {
        $this->reset();
        $this->editeState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
            $inventory = Validator::make($this->state, [
                'stock_id' => 'required|integer',
                'product_id' => 'required|numeric',
            ])->validate();
            productInventory::create($inventory);
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Record added successfully!']);
            return redirect()->back();
    }

    public function edit(productInventory $inventory)
    {
        $this->inventory = $inventory;
        $this->editeState = true;
        $this->state = $inventory->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $inventory = Validator::make($this->state, [
            'stock_id' => 'required|integer',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ])->validate();
        $this->inventory->update($inventory);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'purchase updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $inventory = productInventory::getRecord($this->confirmationDeleteId);
        $inventory->delete();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
    }
}
