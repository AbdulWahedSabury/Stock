<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()->with('provider','inventory')
        ->where('quantity','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::findOrFail($id);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class)->withTrashed();
    }

    public function inventory()
    {
        return $this->belongsTo(productInventory::class);
    }

}
