<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()
        ->where('name','like','%'.$search.'%')
        ->orWhere('responsible','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::findOrFail($id);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
