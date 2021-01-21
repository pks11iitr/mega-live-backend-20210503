<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory, Active;

    protected $table='membership';
    protected $fillable=['title', 'description', 'price', 'validity_days', 'isactive'];
    protected $hidden = ['created_at','deleted_at','updated_at'];
}
