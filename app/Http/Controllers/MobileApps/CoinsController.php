<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Membership;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    
    
     public function genrate_order($userid){
         
         $unique_id = time() . mt_rand() . $userid;
         return $unique_id;       
    }
    
    
    public function index()
    {   
        
        $user=auth()->guard('customerapi')->user();
        $orderid=$this->genrate_order($user->id);
        
        $coins = Coin::active()->get();
        if (count($coins) > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
                'orderid'=>$orderid,
                'data' => compact('coins')
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => 'No Record Found',

            ];

        }

    }

    public function buycoins(Request $request, $plan_id){
        $user=$request->user;

        $coins = Coin::active()->findOrFail($plan_id);

        $payment=Payment::create([
            'type'=>'COINS',
            'amount'=>$coins->price,
            'user_id'=>$user->id
        ]);

        return [
            'status'=>'success',
            'message'=>'Please proceed to payment',
            'data'=>[
                'id'=>$payment->id
            ]
        ];
    }

}


