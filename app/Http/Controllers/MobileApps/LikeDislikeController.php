<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\CoinWallet;
use App\Models\Customer;
use App\Models\LikeDislike;
use Illuminate\Http\Request;

class LikeDislikeController extends Controller
{

    public function ilike(Request $request){
        $user=$request->user;

        $likes=LikeDislike::with('receiver.countryName')
            ->where('sender_id', $user->id)
            ->where('type', 1)
            ->orderBy('id', 'desc')
            ->get();

        $users=[];
        foreach($likes as $like){
            $users[]=[
                'id'=>$like->receiver->id??'',
                'image'=>$like->receiver->image??'',
                'name'=>$like->receiver->name??'',
                'rate'=>$like->receiver->rate??'',
                'age'=>$like->receiver->age??'',
                'country'=>$like->receiver->countryName->name??'',
                'country_flag'=>$like->receiver->countryName->image??''
            ];
        }

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }

    public function likeme(Request $request){
        $user=$request->user;

        $likes=LikeDislike::with('sender.countryName')
            ->where('receiver_id', $user->id)
            ->where('type', 1)
            ->orderBy('id', 'desc')
            ->get();

        $users=[];
        foreach($likes as $like){
            $users[]=[
                'id'=>$like->sender->id,
                'image'=>$like->sender->image,
                'name'=>$like->sender->name,
                'rate'=>$like->sender->rate,
                'age'=>$like->sender->age,
                'country'=>$like->sender->countryName->name??'',
                'country_flag'=>$like->sender->countryName->image??''
            ];
        }

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }



    public function like(Request $request, $id){

        $user=$request->user;

        $receiver=Customer::findOrFail($id);

        LikeDislike::updateOrCreate([
            'sender_id'=>$user->id,
            'receiver_id'=>$id,
        ], ['type'=>1]);

        return [
            'status'=>'success',
            'message'=>'Profile Liked',
            'data'=>[
                'screen'=>(CoinWallet::balance($user->id)>0)?2:1,
                'sender'=>[
                    'name'=>$user->name,
                    'image'=>$user->image,
                    'sendbird_id'=>env('APP_USER_PREFIX').$user->id,
                    'sendbird_token'=>$user->sendbird_token
                ],
                'receiver'=>[
                    'name'=>$receiver->name,
                    'image'=>$receiver->image,
                    'id'=>$receiver->id,
                ]
            ]
        ];

    }


    public function dislike(Request $request, $id){
        $user=$request->user;

        LikeDislike::updateOrCreate([
            'sender_id'=>$user->id,
            'receiver_id'=>$id,
        ], ['type'=>0]);

        return [
            'status'=>'success',
            'message'=>'Profile Disliked'
        ];
    }
}
