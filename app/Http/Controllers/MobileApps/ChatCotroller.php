<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\CoinWallet;
use App\Models\Customer;
use App\Models\Gift;
use App\Services\Notification\FCMNotification;
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

        $unread=Chat::where('seen_at', null)
            ->where(function($query)use($user){
                $query->where(function($query) use($user){
                    $query->where('user_1', $user->id)
                        ->where('direction', 1);
                })->orWhere(function($query) use($user){
                    $query->where('user_2', $user->id)
                        ->where('direction', 0);
                });
            })
            ->groupBy('user_1', 'user_2')
            ->select(DB::raw('count(*) as count'), 'user_1', 'user_2')
            ->get();
        //return $unread;
        $unread_count=[];
        foreach($unread as $u){
            $unread_count[$u->user_1.'-'.$u->user_2]=$u->count??0;
        }


        $userchats=[];
        foreach($chatslist as $userchat){
            if($chats[$userchat->id]->user_1==$user->id){
                $userchats[]=[
                    'id'=>$userchat->user_2,
                    'name'=>$userchat->user2->name,
                    'image'=>$userchat->user2->image,
                    'chat'=>$chats[$userchat->id]->message,
                    'date'=>$chats[$userchat->id]->created_at,
                    'unread'=>$unread_count[$userchat->user_1.'-'.$userchat->user_2]??0
                ];
            }else{
                $userchats[]=[
                    'id'=>$userchat->user_1,
                    'name'=>$userchat->user1->name,
                    'image'=>$userchat->user1->image,
                    'chat'=>$chats[$userchat->id]->message,
                    'date'=>$chats[$userchat->id]->created_at,
                    'unread'=>$unread_count[$userchat->user_1.'-'.$userchat->user_2]??0
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

        Chat::where('seen_at', null)
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->id);
                    });
            })->update(['seen_at'=>date('Y-m-d H:i:s')]);
        DB::enableQueryLog();
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
        dd(DB::getQueryLog());
        $next_page_url=$chatsobj->nextPageUrl();
        $prev_page_url=$chatsobj->previousPageUrl();

        $chats=[];
        foreach ($chatsobj as $c){
            if(($c->user_1==$user->id && $c->direction==0)||($c->user_2==$user->id && $c->direction==1)){
                $chats[]=[
                    'user_id'=>$user->id,
                    'user_image'=>$user->image,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'date'=>$c->created_at,
                    'direction'=>0,
                    'type'=>$c->type
                ];
            }else{
                $chats[]=[
                    'user_id'=>($c->user_1==$user->id)?$c->user2->id:$c->user1->id,
                    'user_image'=>($c->user_1==$user->id)?$c->user2->image:$c->user1->image,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'date'=>$c->created_at,
                    'direction'=>1,
                    'type'=>$c->type
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

            'type'=>'required|in:text,image',
            'message'=>'required_if:type,text',
            'image'=>'required_if:type,image',
        ]);

        $user=$request->user;

        $receiver=Customer::findOrFail($user_id);

        if(config('myconfig.message_charge') > CoinWallet::balance($user->id))
            return [
                'status'=>'failed',
                'message'=>'recharge'
            ];

        CoinWallet::create([
            'sender_id'=>$user->id,
            'receiver_id'=>$receiver->id,
            //'gift_id'=>$gift->id,
            'coins'=>config('myconfig.message_charge'),
        ]);

        $chat=Chat::create([
            'user_1'=>($user->id < $user_id)?$user->id:$user_id,
            'user_2'=>($user->id < $user_id)?$user_id:$user->id,
            'direction'=>($user->id < $user_id)?0:1,
            'message'=>$request->message??'',
            'type'=>$request->type
        ]);

        switch($request->type){
            case 'image':
                $chat->saveImage($request->image, 'chats');
                break;
        }

        $receiver->notify(new FCMNotification('New Message from '.$user->name, $request->message??"[$request->type]", ['type'=>'chat', 'chat_id'=>$user->id.''], 'chat_screen'));

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>[]
        ];

    }


}
