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
        return self::query()->with('inventory','customer')
        // ->where('title','like','%'.$search.'%')
        // ->orWhere('description','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::findOrFail($id);
    }

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }

    public function inventory()
    {
        return $this->belongsTo(productInventory::class);
    }
}
