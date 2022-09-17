<?php
namespace App\Http\Livewire\admin\product;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
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
        $product->deleted_at = Carbon::now();
        $product->save();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
    }

    public function restore($id)
    {
        $product = Product::getRecord($id);
        $product->deleted_at = Null;
        $product->save();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product restored successfully!']);
    }

}
