<?php

namespace App\Http\Controllers\CallerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Customer;
use App\Services\Notification\FCMNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(Request $request, $user_id)
    {

        $user=Auth::user();
        $receiver=Customer::findOrFail($user_id);

        $page=$request->page??'';

        Chat::where('seen_at', null)
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->cusomer_id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->customer_id);
                    });
            })->update(['seen_at'=>date('Y-m-d H:i:s')]);

        $chatsobj=Chat::with(['user1', 'user2'])
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->customer_id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->customer_id);
                    });
            })
            ->orderBy('id','desc')
            ->paginate(10);

        if(count($chatsobj)){
            $recent_ts=$chatsobj[0]->getRawOriginal('created_at');
        }else{
            $recent_ts='0000-00-00 00:00:00';
        }


        $next_page_url=$chatsobj->nextPageUrl();
        $prev_page_url=$chatsobj->previousPageUrl();

        $chats=[];
        foreach ($chatsobj as $c){
            if(($c->user_1==$user->customer_id && $c->direction==0)||($c->user_2==$user->customer_id && $c->direction==1)){
                $chats[]=[
                    'user_id'=>$user->id,
                    'user_image'=>$user->customer->image,
                    'name'=>$user->customer->name,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'created_at'=>$c->created_at,
                    'direction'=>0,
                    'type'=>$c->type
                ];
            }else{
                $chats[]=[
                    'user_id'=>($c->user_1==$user->id)?$c->user2->id:$c->user1->id,
                    'user_image'=>($c->user_1==$user->customer_id)?$c->user2->image:$c->user1->image,
                    'name'=>($c->user_1==$user->customer_id)?$c->user2->name:$c->user1->name,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'created_at'=>$c->created_at,
                    'direction'=>1,
                    'type'=>$c->type
                ];
            }
        }

        $chats=array_reverse($chats);


        //var_dump($request->page);die;
        //return $chats;
        if(!$request->page)
            return view('caller-admin.customer.chat', ['chats' => $chats, 'receiver' => $receiver, 'next_page_url'=>$next_page_url, 'page'=>$page, 'recent_ts'=>$recent_ts]);
        else
            return view('caller-admin.customer.partial-chat', ['chats' => $chats, 'receiver' => $receiver, 'next_page_url'=>$next_page_url, 'page'=>$page, 'recent_ts'=>$recent_ts]);
    }

    public function sendChat(Request $request, $user_id)
    {

        $request->validate([
            'type' => 'required|in:text,image',
            'message' => 'required_if:type,text',
            'image' => 'required_if:type,image',
        ]);
        // var_dump($request->compid);die;
        //  var_dump($request->image); die('aaaa');
        $receiver = Customer::findOrFail($user_id);
        $user = Auth::user();

        //   $receiver=Customer::findOrFail($id);
        // $chats =Chat::orderBy('id','ASC')->limit(20)->where('user_2','=',$id)->get();

        $chat=Chat::create([
            'user_1'=>($user->customer_id < $user_id)?$user->customer_id:$user_id,
            'user_2'=>($user->customer_id < $user_id)?$user_id:$user->cuctomer_id,
            'direction'=>($user->customer_id < $user_id)?0:1,
            'message'=>$request->message??'',
            'type'=>$request->type
        ]);


        if (isset($request->image)) {
            switch ($request->type) {
                case 'image':
                    $chat->saveImage($request->image, 'chats');
                    break;
            }
        }

        $receiver->notify(new FCMNotification('New Message', 'New Message From '.$user->customer->name??'', ['type'=>'Chat']));

        if ($chat) {
            // return view('caller-admin.customer.chat',['chats'=>$chats,'id'=>$id]);
            return response()->json(['chat' => $chat], 200);
        } else {
            return response()->json(['msg' => 'No result found!'], 404);
        }

    }

    public function newchats(Request $request, $user_id){
        //echo $request->recent_ts;die;
        $recent_ts=date('Y-m-d H:i:s', strtotime($request->recent_ts));
        //echo $recent_ts;die;
        $user=Auth::user();
        $receiver=Customer::findOrFail($user_id);

        $page=$request->page??'';

        Chat::where('seen_at', null)
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->cusomer_id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->customer_id);
                    });
            })->update(['seen_at'=>date('Y-m-d H:i:s')]);

        $chatsobj=Chat::with(['user1', 'user2'])
            ->where(function($query) use($user, $user_id){
                $query->where(function($query) use($user, $user_id){
                    $query->where('user_1', $user->customer_id)
                        ->where('user_2', $user_id);
                })
                    ->orWhere(function($query) use($user, $user_id){
                        $query->where('user_1', $user_id)
                            ->where('user_2', $user->customer_id);
                    });
            })
            ->where('created_at', '>', $recent_ts)
            ->orderBy('id','desc')
            ->get();

        if(count($chatsobj)){
            $recent_ts=$chatsobj[0]->getRawOriginal('created_at');
        }else{
            $recent_ts='0000-00-00 00:00:00';
        }

        $chats=[];
        foreach ($chatsobj as $c){
            if(($c->user_1==$user->customer_id && $c->direction==0)||($c->user_2==$user->customer_id && $c->direction==1)){
                $chats[]=[
                    'user_id'=>$user->id,
                    'user_image'=>$user->customer->image,
                    'name'=>$user->customer->name,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'created_at'=>$c->created_at,
                    'direction'=>0,
                    'type'=>$c->type
                ];
            }else{
                $chats[]=[
                    'user_id'=>($c->user_1==$user->id)?$c->user2->id:$c->user1->id,
                    'user_image'=>($c->user_1==$user->customer_id)?$c->user2->image:$c->user1->image,
                    'name'=>($c->user_1==$user->customer_id)?$c->user2->name:$c->user1->name,
                    'image'=>$c->image,
                    'message'=>$c->message,
                    'created_at'=>$c->created_at,
                    'direction'=>1,
                    'type'=>$c->type
                ];
            }
        }

        $chats=array_reverse($chats);

        return view('caller-admin.customer.new-chat', ['chats' => $chats, 'receiver' => $receiver, 'recent_ts'=>$recent_ts]);

    }
}
