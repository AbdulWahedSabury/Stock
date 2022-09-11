<?php

namespace App\Http\Livewire\Admin\ProductInventory;

use App\Models\Product;
use App\Models\product_inventory;
use App\Models\Stock;
use Livewire\Component;

class ProductInventoryList extends Component
{
    public $search;
    public $inventory;
    public $state = [];
    public $editeState = false;
    public $confirmationDeleteId;
    public function render()
    {
        $stocks = Stock::getRecords();
        $products = Product::getRecords();
        $inventories = product_inventory::getRecords($this->state);
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
        dd($this->state);
    }
}
