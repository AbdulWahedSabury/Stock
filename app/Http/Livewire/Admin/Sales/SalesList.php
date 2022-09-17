<?php

namespace App\Http\Livewire\Admin\Sales;

use Exception;
use Throwable;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\customer;
use Livewire\WithPagination;
use App\Models\productInventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class SalesList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $list;
    public $state = [];
    public $selectedInventory;
    public $editeState  = false;
    public $confirmationProductDeleteId;

    public function render()
    {
        $sales = Sale::getRecords();
        $inventories = productInventory::getRecordsForSale();
        $customers = customer::getRecordsForSale();
        return view('livewire.admin.sales.sales-list',[
                'sales' => $sales,
                'inventories' => $inventories,
                'customers' => $customers,
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
        $list = Validator::make($this->state, [
            'customer_id' => 'required|integer',
            'inventory_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            's_price' => 'required|numeric',
        ])->validate();

        try {
            DB::beginTransaction();

            $list['total_price'] = $list['quantity'] * $list['s_price'];

            $this->selectedInventory = productInventory::getRecord($list['inventory_id']);
            $this->selectedInventory['quantity'] -= $list['quantity'];

            $this->selectedInventory->update();
            Sale::create($list);

            DB::commit();
            $this->dispatchBrowserEvent('hide-form', ['message' => 'list added successfully!']);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
    }

    public function edit(Sale $list)
    {
        $this->list = $list;
        $this->editeState  = true;
        $this->state = $list->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
            $list = Validator::make($this->state, [
                'customer_id' => 'required|integer',
                'inventory_id' => 'required|numeric',
                'quantity' => 'required|numeric',
                's_price' => 'required|numeric',
            ])->validate();

            try {
                DB::beginTransaction();
                $list['total_price'] = $list['quantity'] * $list['s_price'];

                $this->selectedInventory = productInventory::getRecord($list['inventory_id']);
                $previousList = Sale::getRecord($this->state['id']);


            if($list['quantity'] > $previousList['quantity']){
                $newQuantity = $list['quantity'] - $previousList['quantity'];
                $this->selectedInventory->quantity -= $newQuantity;
            }

            if ($list['quantity'] < $previousList['quantity']){
                $newQuantity = $previousList['quantity'] - $list['quantity'];
                $this->selectedInventory->quantity += $newQuantity;
            }
                $this->selectedInventory->save();
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
            $list = Sale::getRecord($this->confirmationDeleteId);
            $this->selectedInventory = productInventory::getRecord($list['inventory_id']);

            $this->selectedInventory['quantity'] += $list['quantity'];

            $this->selectedInventory->save();
            $list->delete();

            DB::commit();
            $this->dispatchBrowserEvent('hide-delete-form',['message'=>'product Deleted successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('error', ['message' => 'Some thing is wrong try again!']);
            return redirect()->back();
        }
    }
}
