<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table='payments';

    protected $fillable=['entity_id', 'entity_type', 'user_id', 'amount', 'is_complete', 'refid','order_id'];


    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'user_id');
    }

    public function entity(){
        return $this->morphTo();
    }



}
