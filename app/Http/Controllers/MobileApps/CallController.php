<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\CoinWallet;
use App\Models\Customer;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function initiateVideoCall(Request $request, $profile_id){
        $user=$request->user;
        if($user->account_type=='USER')
            $receiver=Customer::where('account_type', 'ADMIN')
                ->findOrFail($profile_id);
        else
            $receiver=Customer::findOrFail($profile_id);

        //check balance for non admin users
        if($user->account_type!='ADMIN'){
            $balance=CoinWallet::balance($user->id);
            if( $balance < 50)
                return [
                    'status'=>'failed',
                    'message'=>'recharge'
                ];
            $minutes=floor($balance/$receiver->rate);
        }
        else{
            $balance=CoinWallet::balance($receiver->id);
            if( $balance < 50)
                return [
                    'status'=>'failed',
                    'message'=>'Low balance'
                ];
            $minutes=floor($balance/$user->rate);
        }

        $user_id=env('APP_USER_PREFIX').$receiver->id;

        return [
            'status'=>'success',
            'data'=>compact('user_id', 'minutes')
        ];

    }
}
