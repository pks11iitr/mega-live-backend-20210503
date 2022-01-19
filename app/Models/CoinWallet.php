<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinWallet extends Model
{
    use HasFactory;

    protected $table='coinwallet';

    protected $fillable=['sender_id', 'receiver_id', 'gift_id', 'coins', 'message'];

    public function sender(){
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    public function recivecoins(){
        return $this->belongsTo('App\Models\Customer', 'receiver_id');
    }

    public static function balance($user_id){
            $received=CoinWallet::where('receiver_id', $user_id)
                ->sum('coins');
            $sent=CoinWallet::where('sender_id', $user_id)
                ->sum('coins');
            return ($received??0)-($sent??0);
    }

    public function gift(){
        return $this->belongsTo('App\Models\Gift', 'gift_id');
    }



}
