<?php

namespace App\Http\Controllers\CallerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Customer;
use App\Services\Notification\FCMNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->orderBy('last_active','DESC')
            ->paginate(10);

        return view('caller-admin.customer.view',['customers'=>$customers]);
    }

    public function chat(Request $request,$id){
        $chats =Chat::orderBy('id','ASC')->where('user_2','=',$id)->paginate(5);

        return view('caller-admin.customer.chat',['chats'=>$chats,'id'=>$id]);
    }

    public function sendChat(Request $request){

       $request->validate([
            'type'=>'required|in:text,image',
           'message'=>'required_if:type,text',
            'image'=>'required_if:type,image',
        ]);
       // var_dump($request->compid);die;
      //  var_dump($request->image); die('aaaa');
       $id=$request->compid;
        $user=Auth::user();

     //   $receiver=Customer::findOrFail($id);
       // $chats =Chat::orderBy('id','ASC')->limit(20)->where('user_2','=',$id)->get();

        $chat=Chat::create([
            'user_1'=>$user->customer_id,
            'user_2'=>$id,
            'direction'=>0,
            'message'=>$request->message,
            'type'=>$request->type
        ]);


        if(isset($request->image)){
            switch($request->type){
                case 'image':
                    $chat->saveImage($request->image, 'chats');
                    break;
            }
        }


      /*  $receiver->notify(new FCMNotification('New Chat', 'New Chat From User', ['message'=>'New Chat']));*/

        if($chat){
           // return view('caller-admin.customer.chat',['chats'=>$chats,'id'=>$id]);
            return response()->json(['chat' => $chat], 200);
        }else{
            return response()->json(['msg' => 'No result found!'], 404);
        }

    }
}
