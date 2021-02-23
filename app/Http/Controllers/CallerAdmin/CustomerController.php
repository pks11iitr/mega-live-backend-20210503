<?php

namespace App\Http\Controllers\CallerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Customer;
use App\Services\Notification\FCMNotification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customers=Customer::where(function($customers) use($request){
            $customers->where('name','LIKE','%'.$request->search.'%')
                ->orWhere('mobile','LIKE','%'.$request->search.'%')
                ->orWhere('email','LIKE','%'.$request->search.'%');
        });

        if($request->fromdate)
            $customers=$customers->where('created_at', '>=', $request->fromdate.' 00:00:00');

        if($request->todate)
            $customers=$customers->where('created_at', '<=', $request->todate.' 23:59:50');

        if($request->status)
            $customers=$customers->where('status', $request->status);

        if($request->ordertype)
            $customers=$customers->orderBy('created_at', $request->ordertype);

        $customers=$customers->where('account_type','USER')
            ->orderBy('late_active','DESC')
            ->paginate(10);

        return view('caller-admin.customer.view',['customers'=>$customers]);
    }

    public function chat(Request $request,$id){
        $chats =Chat::orderBy('id','ASC')->where('user_2','=',$id)->get();
        return view('caller-admin.customer.chat',['chats'=>$chats]);
    }

    public function sendChat(Request $request,$id){

        $request->validate([
            'type'=>'required|in:text,image',
            'message'=>'required_if:type,text',
            'image'=>'required_if:type,image',
        ]);

        $user=$request->user;

        $receiver=Customer::findOrFail($id);

        $chat=Chat::create([
            'user_1'=>($user->id < $id)?$user->id:$id,
            'user_2'=>($user->id < $id)?$id:$user->id,
            'direction'=>($user->id < $id)?0:1,
            'message'=>$request->message??'',
            'type'=>$request->type
        ]);

        switch($request->type){
            case 'image':
                $chat->saveImage($request->image, 'chats');
                break;
        }

        $receiver->notify(new FCMNotification('New Chat', 'New Chat From User', ['message'=>'New Chat']));

        if($chat){
            return response()->json(['chat' => $chat], 200);
        }else{
            return response()->json(['msg' => 'No result found!'], 404);
        }

    }
}
