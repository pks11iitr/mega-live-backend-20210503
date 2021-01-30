<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\LikeDislike;
use Illuminate\Http\Request;

class LikeDislikeController extends Controller
{

    public function ilike(Request $request){
        $user=$request->user;

        $likes=LikeDislike::with('receiver')
            ->where('sender_id', $user->id)
            ->where('type', 1)
            ->orderBy('id', 'desc')
            ->get();

        $users=[];
        foreach($likes as $like){
            $users[]=[
                'id'=>$like->receiver->id,
                'image'=>$like->receiver->image,
                'name'=>$like->receiver->name,
                'rate'=>$like->receiver->rate,
                'age'=>$like->receiver->age,
                'country'=>$like->receiver->country,
                'country_flag'=>$like->receiver->country_flag
            ];
        }

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }

    public function likeme(Request $request){
        $user=$request->user;

        $likes=LikeDislike::with('sender')
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
                'country'=>$like->sender->country,
                'country_flag'=>$like->sender->country_flag
            ];
        }

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }



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
