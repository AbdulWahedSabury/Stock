<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productInventory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function getRecords($search = null)
    {
        return self::query()->with('stock', 'product')
            // ->where('name','like','%'.$search.'%')
            // ->orWhere('description','like','%'.$search.'%')
            ->paginate(5);
    }

    public function getRecord($product_id = null, $stock_id =null)
    {
        return self::where('product_id','=',$product_id)
        ->where('product_id','=',$product_id)->first();
    }

    public function getRecordsForSale($id)
    {
        return self::where('quantity','>',0)
        ->where('product_id','=',$id)->get();
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
