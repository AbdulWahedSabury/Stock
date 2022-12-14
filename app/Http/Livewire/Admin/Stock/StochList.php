<?php

namespace App\Http\Livewire\Admin\Stock;

use Carbon\Carbon;
use App\Models\Stock;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class StochList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $editeState = false;
    public $state = [];
    public $stock;
    public $confirmationDeleteId;
    public function render()
    {
        $stocks = Stock::getRecords($this->search);
        return view('livewire.admin.stock.stoch-list',
            ['stocks' => $stocks]
        )->layout('admin.layouts.app');
    }

    public function add()
    {
        $this->reset();
        $this->editeState = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function create()
    {
        $stock = Validator::make($this->state, [
            'name' => 'required|string',
            'address' => 'string'
        ])->validate();
        Stock::create($stock);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Stock added successfully!']);
        return redirect()->back();
    }

    public function edit(Stock $stock)
    {
        $this->stock = $stock;
        $this->editeState = true;
        $this->state = $stock->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function saveChanges()
    {
        $stock = Validator::make($this->state, [
            'name' => 'required|string',
            'address' => 'string'
        ])->validate();
        $this->stock->update($stock);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'stock updated successfully!']);
    }

    public function ConfirmationDelete($Id)
    {
        $this->confirmationDeleteId = $Id;
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function delete()
    {
        $stock = Stock::getRecord($this->confirmationDeleteId);
        $stock->deleted_at = Carbon::now();
        $stock->save();
        $this->dispatchBrowserEvent('hide-delete-form', ['message' => 'stock Deleted successfully!']);
    }

    public function restore($id)
    {
        $stock = Stock::getRecord($id);
        $stock->deleted_at = Null;
        $stock->save();
        $this->dispatchBrowserEvent('hide-delete-form',['message'=>'customer restored successfully!']);
    }
}
