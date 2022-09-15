<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()
        ->withTrashed()
        ->where('name','like','%'.$search.'%')
        ->orWhere('description','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecordsForAddToInventory()
    {
        return self::all();
    }

    public function getRecord($id)
    {
        return self::withTrashed()->findOrFail($id);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class)->withTrashed();
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

}
