<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function ward()
    {
        return $this->hasMany(Ward::class);
    }
}
