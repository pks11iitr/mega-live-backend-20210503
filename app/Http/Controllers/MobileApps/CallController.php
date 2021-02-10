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
        $receiver=Customer::where('account_type', 'ADMIN')
            ->findOrFail($profile_id);

        if(CoinWallet::balance($user->id) < 50)
            return [
                'status'=>'failed',
                'message'=>'recharge'
            ];

        $user_id='Matchon'.$receiver->id;

        return [
            'status'=>'success',
            'data'=>compact('user_id')
        ];

    }
}
