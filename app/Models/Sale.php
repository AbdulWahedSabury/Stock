<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRecords($search = null)
    {
        return self::query()->with('product','customer','stock')
        // ->where('title','like','%'.$search.'%')
        // ->orWhere('description','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
