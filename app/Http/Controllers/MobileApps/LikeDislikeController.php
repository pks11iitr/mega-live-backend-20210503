<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\LikeDislike;
use Illuminate\Http\Request;

class LikeDislikeController extends Controller
{
    public function like(Request $request, $id){

        $user=$request->user;

        LikeDislike::updateOrCreate([
            'sender_id'=>$user->id,
            'receiver_id'=>$id,
        ], ['type'=>1]);

        return [
            'status'=>'success',
            'message'=>'Profile Liked'
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
