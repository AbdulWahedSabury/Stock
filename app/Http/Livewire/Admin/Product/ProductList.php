<?php
namespace App\Http\Livewire\admin\product;
use App\Models\Product;
use Livewire\Component;
use App\Models\Provider;
use Illuminate\Support\Facades\Validator;

class ProductList extends Component
{
    public $search;
    public $product;
    public $state = [];
    public $editeState = false;
    public $confirmationDeleteId;
    public function render()
    {
        $products = Product::getRecords($this->search);
        return view('livewire.admin.product.product-list',
        ['products' => $products])->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
        $product = Validator::make($this->state, [
            'name' => 'required|string',
            'description' => 'required|string'
        ])->validate();
        Product::create($product);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Product added successfully!']);
        return redirect()->back();
    }

    public function edit(Product $product)
    {
        $this->product = $product;
        $this->editeState = true;
        $this->state = $product->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $product = Validator::make($this->state, [
            'name' => 'required|string',
            'description' => 'required|string'
        ])->validate();
        $this->product->update($product);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'product updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $product = Product::getRecord($this->confirmationDeleteId);
        $product->delete();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
    }

}
