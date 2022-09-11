<?php

namespace App\Models;

use App\Http\Livewire\Admin\Customers\CustomersList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()->with('product')->with('customer')
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
}
