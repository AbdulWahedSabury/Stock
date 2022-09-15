<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()
        ->withTrashed()
        ->where('name','like','%'.$search.'%')
        ->orWhere('responsible','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::withTrashed()->findOrFail($id);
    }

    public function getRecordsForPurchase()
    {
        return self::all();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
