<?php

namespace App\Http\Livewire\Admin\ProductInventory;

use Throwable;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\product_inventory;
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
        try{
            $list = Validator::make($this->state, [
                'stock_id' => 'required|integer',
                'product_id' => 'required|numeric',
                'quantity' => 'required|numeric',
            ])->validate();
            $this->selectedProduct = Product::getRecord($list['product_id']);
            if($list['quantity'] > $this->selectedProduct['quantity']){
                $this->dispatchBrowserEvent('error', ['message' => 'please enter a valid quantity!']);
                return redirect()->back();
            }
            $this->selectedProduct['quantity'] -= $list['quantity'];
            productInventory::create($list);
            $this->selectedProduct->update();
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Record added successfully!']);
            return redirect()->back();
        } catch (Throwable $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
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
        $list = Validator::make($this->state, [
            'stock_id' => 'required|integer',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ])->validate();
        $this->list->update($list);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'purchase updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $list = Purchase::getRecord($this->confirmationDeleteId);
        $list->delete();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
    }
}
