<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\CoinWallet;
use App\Models\Customer;
use App\Models\Gift;
use App\Models\Membership;
use Illuminate\Http\Request;

class GiftsController extends Controller
{
    public function index(Request $request){

        $user=$request->user;

        $gifts=Gift::active()
            ->select('id', 'name', 'image', 'coins')
            ->get();


        return [
            'status'=>'success',
            'data'=>compact('gifts')
        ];

    }


    public function sendGift(Request $request){
        $user=$request->user;
        //var_dump($user->toArray());die;

        $gift=Gift::active()->findOrFail($request->gift_id);
        $receiver=Customer::findOrFail($request->profile_id);

        if($gift->coins<CoinWallet::balance($user->id)){
            CoinWallet::create([
               'sender_id'=>$user->id,
               'receiver_id'=>$receiver->id,
               'gift_id'=>$gift->id,
               'coins'=>$gift->coins,
            ]);

            $chat=Chat::create([
                'user_1'=>$user->id,
                'user_2'=>$receiver->id,
                'message'=>$request->message??'',
                'type'=>'gift',
                'image'=>$gift->getRawOriginal('image')
            ]);

            $chat->save();

            return [
                'status'=>'success',
                'message'=>'Gift Sent Successfully'
            ];


        }

        return [
            'status'=>'failed',
            'message'=>'Recharge coins balance'
        ];

    }

}
