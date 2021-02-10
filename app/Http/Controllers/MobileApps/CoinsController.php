<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Membership;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    public function index()
    {
        $coins = Coin::active()->get();
        if (count($coins) > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
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


