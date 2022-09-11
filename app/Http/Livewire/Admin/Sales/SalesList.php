<?php

namespace App\Http\Livewire\Admin\Sales;

use Exception;
use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;

class SalesList extends Component
{
    public $search;
    public $sale;
    public $state = [];
    public $selectedProduct;
    public $productValidInventory;
    public $editeSaleState = false;
    public $confirmationProductDeleteId;
    public function render()
    {
        $sales = Sale::getRecords();
        $products = Product::getRecordsForSale();
        $customers = customer::getRecords();
        return view('livewire.admin.sales.sales-list',
        ['sales' => $sales,
        'products' => $products,
        'customers' => $customers
        ])->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeSaleState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
        $sale = Validator::make($this->state, [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'customer_id' => 'required|integer',
        ])->validate();
        $this->selectedProduct = Product::getRecord($sale['product_id']);
        $sale['total_price'] = $sale['quantity'] * $this->selectedProduct['s_price'];
        $this->selectedProduct['quantity_sold'] += $sale['quantity'];
        Sale::create($sale);
        $this->selectedProduct->update();
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Record added successfully!']);
        return redirect()->back();

    }

    public function productInventroy()
    {
        $this->productValidInventory =Product::getRecord($this->state['product_id']);
    }
}
