<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $table='earnings';

    protected $fillable=['user_id', 'type', 'count', 'coins', 'date'];

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'user_id');
    }
}
