<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function getRecords($search = null)
    {
        return self::query()
        ->where('name','like','%'.$search.'%')
        ->orWhere('address','like','%'.$search.'%')
        ->latest()->paginate(5);
    }
    public function getRecord($id)
    {
        return self::findOrFail($id);
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
