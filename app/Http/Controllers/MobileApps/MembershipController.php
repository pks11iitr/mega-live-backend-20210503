<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request){


        $user=$request->user;

        $memberships=Membership::active()->get();

        $active=[
            'plan_id'=>(($user->membership_expiry??null)>=date('Y-m-d'))?$user->plan_id:0,
            'is_active'=>(($user->membership_expiry??null)>=date('Y-m-d'))?1:0
        ];

        return [

            'status'=>'success',
            'data'=>compact('memberships', 'active')

        ];

    }

    public function subscribe(Request $request, $plan_id){
        $user=$request->user;

        $membership=Membership::active()->findOrFail($plan_id);

        $payment=Payment::create([
            'type'=>'MEMBERSHIP',
            'amount'=>$membership->price,
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
