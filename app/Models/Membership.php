<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory, Active;

    protected $table='memberships';


    protected $fillable=['title', 'description', 'price', 'cut_price', 'isactive'];
}
