<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BondedWood;
use App\Models\NonBondedWood;

class Wood extends Model
{
    use HasFactory;

    protected $fillable = [
        'wood_name',
    ];

    public function bondedWood(){
        return $this->hasMany(BondedWood::class);
    }

    public function nonBondedWood(){
        return $this->hasMany(NonBondedWood::class);
    }
}
