<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded =[];
    public function getRecords($search = null)
    {
        return self::query()
        ->withTrashed()
        ->where('name','like','%'.$search.'%')
        ->orWhere('address','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::withTrashed()->findOrFail($id);
    }

    public function getRecordsForAddToInventory()
    {
        return self::all();
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_inventories',
            'stock_id',
            'product_id'
        )->withPivot('quantity');
    }
}
