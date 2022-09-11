<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()
        ->where('name','like','%'.$search.'%')
        ->orWhere('description','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::findOrFail($id);
    }
    public function getRecordsForSale()
    {
        return self::where('quantity','>','quantity_sold')->get();
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function stocks()
    {
        return $this->belongsToMany(
            Stock::class,
            'product_inventories',
            'stock_id',
            'product_id'
        )->withPivot('quantity');
    }

    public function getInventoryRecords()
    {
        return self::whereHas('stocks')->latest()->paginate(5);
    }
}
