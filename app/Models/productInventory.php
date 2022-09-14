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

    public function getRecord($id)
    {
        return self::where('id','=',$id)->first();
    }

    public function getRecordsForSale()
    {
        return self::where('quantity','>',0)->get();
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
