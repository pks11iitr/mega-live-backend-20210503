<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
    use HasFactory;

    protected $table='likes_dislikes';

    protected $fillable=['sender_id', 'receiver_id', 'type'];

    public function sender(){
        return $this->belongsTo('App\Models\Customer', 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo('App\Models\Customer', 'receiver_id');
    }
}
