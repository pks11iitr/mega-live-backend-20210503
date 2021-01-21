<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory, Active;

    protected $table='coins';
    protected $fillable=['coin', 'price', 'isactive'];
    protected $hidden = ['created_at','deleted_at','updated_at'];
}
