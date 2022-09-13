<?php

namespace App\Http\Livewire\Admin\Sales;

use Exception;
use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\customer;
use App\Models\productInventory;
use App\Models\Stock;
use Illuminate\Support\Facades\Request;
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
    protected $listeners = ['productSelected' => 'getSelectdProducts'];
    public function render()
    {
        $sales = Sale::getRecords();
        $products = Product::getRecords();
        $customers = customer::getRecords();
        $stocks = Stock::getRecords();
        return view(
            'livewire.admin.sales.sales-list',
            [
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

    public function create()
    {
        dd($this->state);
        exit;
        $sale = Validator::make($this->state, [
            'customer_id' => 'required|integer',
            'stock_id' => 'required|integer',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            's_price' => 'required|numeric',
        ])->validate();
        $this->selectedProduct = Product::getRecord($sale['product_id']);
        $sale['total_price'] = $sale['quantity'] * $this->selectedProduct['s_price'];
        $this->selectedProduct['quantity_sold'] += $sale['quantity'];
        Sale::create($sale);
        $this->selectedProduct->update();
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Record added successfully!']);
        return redirect()->back();
    }
    public function getSelectdProducts($id)
    {
        $this->reset();
        $this->productValidInventory = productInventory::getRecordsForSale($id);
        dd($this->productValidInventory);
    }
}
