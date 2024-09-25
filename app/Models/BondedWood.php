<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeWood;
use App\Models\Wood;

class BondedWood extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_type',
        'id_wood',
        'image',
        'size',
        'price',
        'quantity',
    ];

    public function woodType(){
        return $this->belongsTo(TypeWood::class, 'id_type', 'id');
    }

    public function wood(){
        return $this->belongsTo(Wood::class, 'id_wood', "id");
    }
}
