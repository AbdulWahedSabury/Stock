<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function getRecords($search = null)
    {
        return self::query()
        ->withTrashed()
        ->where('name','like','%'.$search.'%')
        ->orWhere('last_name','like','%'.$search.'%')
        ->latest()->paginate(5);
    }

    public function getRecord($id)
    {
        return self::withTrashed()->findOrFail($id);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
