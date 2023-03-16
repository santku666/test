<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qty_management extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="qty_managements";
    protected $fillable=[
        "material_id","date","qty"
    ];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id','id');
    }
}
