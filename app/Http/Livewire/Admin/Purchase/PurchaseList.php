<?php

namespace App\Http\Livewire\Admin\Purchase;

use App\Models\Product;
use Livewire\Component;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\productInventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseList extends Component
{
    public $search;
    public $list;
    public $state = [];
    public $editeState = false;
    public $confirmationDeleteId;
    public $selectedInventory;
    public $selectedProduct;


    public function render()
    {
        $lists = Purchase::getRecords($this->search);
        $providers = Provider::getRecordsForPurchase();
        $inventories = productInventory::getRecordsForPurchase ();

        return view('livewire.admin.purchase.purchase-list',
        ['lists' => $lists,
        'providers' => $providers,
        'inventories' => $inventories])->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {

        $list = Validator::make($this->state, [
            'provider_id' => 'required|numeric',
            'inventory_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'p_price' => 'required|numeric'
        ])->validate();

        try {
            DB::beginTransaction();
            $list['total_price'] = $this->state['p_price'] * $this->state['quantity'];

            $this->selectedInventory = productInventory::getRecord($list['inventory_id']);
            $this->selectedInventory->quantity += $this->state['quantity'];

            $this->selectedProduct = Product::getRecord($this->selectedInventory->product_id);

            $this->selectedProduct->p_price = $list['p_price'];

            $this->selectedInventory->save();
            $this->selectedProduct->save();
            Purchase::create($list);

            DB::commit();
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Product added successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
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
            'provider_id' => 'required|numeric',
            'inventory_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'p_price' => 'required|numeric'
        ])->validate();

        try {
            DB::beginTransaction();
            $list['total_price'] = $this->state['p_price'] * $this->state['quantity'];

            $this->selectedInventory = productInventory::getRecord($list['inventory_id']);
            $this->selectedProduct = Product::getRecord($this->selectedInventory->product_id);
            $previousList = Purchase::getRecord($this->state['id']);

            if($list['quantity'] > $previousList['quantity']){
                $newQuantity = $list['quantity'] - $previousList['quantity'];
                $this->selectedInventory->quantity += $newQuantity;
            }

            if ($list['quantity'] < $previousList['quantity']){
                $newQuantity = $previousList['quantity'] - $list['quantity'];
                $this->selectedInventory->quantity -= $newQuantity;
            }
            $this->selectedProduct->p_price = $list['p_price'];

            $this->selectedInventory->save();
            $this->selectedProduct->save();
            $this->list->update($list);

            DB::commit();
            $this->dispatchBrowserEvent('hide-form', ['message' => 'list Updated successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }

    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
        $list = Purchase::getRecord($this->confirmationDeleteId);
        $this->selectedInventory = productInventory::getRecord($list['inventory_id']);

        $this->selectedInventory['quantity'] -= $list['quantity'];

        $this->selectedInventory->save();
        $list->delete();

        DB::commit();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
        return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
    }

}
