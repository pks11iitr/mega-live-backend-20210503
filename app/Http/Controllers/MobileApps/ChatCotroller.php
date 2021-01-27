<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatCotroller extends Controller
{
    public function chatlist(Request $request){

        $user=$request->user;

        $chatslist=Chat::with(['user1'=>function($user){
            $user->select('id', 'name', 'image');
        }, 'user2'=>function($user){
            $user->select('id', 'name', 'image');
        }])
            ->select(DB::raw('max(id) as id'), 'user_1', 'user_2')
            ->groupBy('user_1', 'user_2')
            ->where(function($query) use ($user){
                $query->where('user_1', $user->id)
                ->orWhere('user_2', $user->id);
            })
            ->orderBy('id', 'desc')
            ->get();

        $chatids=[];
        foreach($chatslist as $chatid){
            $chatids[]=$chatid->id;
        }

        $chats=[];
        if(!empty($chatids)){
            $chatobj=Chat::whereIn('id', $chatids)
            ->get();
            foreach($chatobj as $chat){
                $chats[$chat->id]=$chat;
            }

        }


        $userchats=[];
        foreach($chatslist as $userchat){
            if($chats[$userchat->id]->user_1==$user->id){
                $userchats[]=[
                    'id'=>$userchat->user_2,
                    'name'=>$userchat->user2->name,
                    'image'=>$userchat->user2->image,
                    'chat'=>$chats[$userchat->id]->message,
                    'date'=>$chats[$userchat->id]->created_at
                ];
            }else{
                $userchats[]=[
                    'id'=>$userchat->user_1,
                    'name'=>$userchat->user1->name,
                    'image'=>$userchat->user1->image,
                    'chat'=>$chats[$userchat->id]->message,
                    'date'=>$chats[$userchat->id]->created_at
                ];
            }
        }

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>compact('userchats')
        ];


    }

    public function chatDetails(Request $request, $user_id){

        $user=$request->user;

        $chatsobj=Chat::with(['user1', 'user2'])
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->id);
                });
            })
            ->orderBy('id','asc')
            ->paginate(20);

        $next_page_url=$chatsobj->nextPageUrl();
        $prev_page_url=$chatsobj->previousPageUrl();

        $chats=[];
        foreach ($chatsobj as $c){
            if($c->user_1==$user->id){
                $chats[]=[
                    'user_id'=>$c->user2->id,
                    'user_image'=>$c->user2->image,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'date'=>$c->created_at,
                    'direction'=>0,
                ];
            }else{
                $chats[]=[
                    'user_id'=>$c->user1->id,
                    'user_image'=>$c->user1->image,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'date'=>$c->created_at,
                    'direction'=>1
                ];
            }
        }

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>compact('chats', 'next_page_url', 'prev_page_url')
        ];

    }


    public function send(Request $request, $user_id){

        $request->validate([
            'message'=>'required',
            'type'=>'required|in:text,image',
            'image'=>'required_if:type,image',
        ]);

        $user=$request->user;

        $chat=Chat::create([
            'user_1'=>$user->id,
            'user_2'=>$user_id,
            'message'=>$request->message??'',
            'type'=>$request->type
        ]);

        switch($request->type){
            case 'image':
                $chat->saveImage($request->image, 'chats');
                break;
        }

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>[]
        ];

    }


}
