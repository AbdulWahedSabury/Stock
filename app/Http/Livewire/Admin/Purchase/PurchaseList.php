<?php

namespace App\Http\Livewire\Admin\Purchase;

use Throwable;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\Provider;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;

class PurchaseList extends Component
{
    public $search;
    public $list;
    public $state = [];
    public $editeState = false;
    public $confirmationDeleteId;
    public $selectedProduct;


    public function render()
    {
        $lists = Purchase::getRecords($this->search);
        $providers = Provider::getRecords();
        $products = Product::getRecords();
        $stocks = Stock::getRecords();
        return view('livewire.admin.purchase.purchase-list',
        ['lists' => $lists,
        'providers' => $providers,
        'products' => $products,
        'stocks' => $stocks])->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeState = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function create()
    {
        dd($this->state);
        try {
            $list = Validator::make($this->state, [
                'product_id' => 'required|numeric',
                'provider_id' => 'required|numeric',
                'stock_id' => 'required|numeric',
                'quantity' => 'required|numeric',
                'p_price' => 'required|numeric'
            ])->validate();
            $list['total_price'] = $this->state['p_price'] * $this->state['quantity'];
            $this->selectedProduct = Product::getRecord($list['product_id']);
            $this->selectedProduct['quantity'] += $list['quantity'];
            $this->selectedProduct['p_price'] = $list['p_price'];
            $this->selectedProduct->update();
            Purchase::create($list);
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Product added successfully!']);
            return redirect()->back();
        } catch (Throwable $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
    }

    public function edit(Purchase $list)
    {
        $this->list = $list;
        $this->editeState = true;
        $this->state = $list->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $list = Validator::make($this->state, [
            'product_id' => 'required|numeric',
            'provider_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'p_price' => 'required|numeric'
        ])->validate();
        $list['total_price'] = $this->state['p_price'] * $this->state['quantity'];
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
