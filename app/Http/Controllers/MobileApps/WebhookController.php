<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\CallRecord;
use App\Models\CoinWallet;
use App\Models\Customer;
use App\Models\LogData;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function receive(Request $request){

        $content=Request::createFromGlobals()->getContent();

        LogData::create([
            'data'=>$content,
            'type'=>'call'
        ]);

        $content=json_decode($content, true);

        if(isset($content['category']) && isset($content['direct_call']) && isset($content['direct_call']['call_id']) && isset($content['direct_call']['caller_id']) && isset($content['direct_call']['callee_id'])){
            if($content['category']=='direct_call:dial'){
                $caller=str_replace('Matchon', '', $content['direct_call']['caller_id']);
                $callee=str_replace('Matchon', '', $content['direct_call']['callee_id']);

                $caller=Customer::find($caller);
                $callee=Customer::find($callee);

                if(isset($content['sendbird_call']['payload']['is_video_call'])){
                    if($content['sendbird_call']['payload']['is_video_call']){
                        $type='VIDEO';
                    }else
                        $type='CALL';
                }else{
                    $type='CALL';
                }

                if($caller && $callee){
                    CallRecord::create([
                        'call_id'=>$content['direct_call']['call_id'],
                        'caller_id'=>$caller->id,
                        'callee_id'=>$callee->id,
                        'type'=>$type,
                        'minutes'=>0,
                        'start'=>0,
                        'end'=>0,
                        'coins'=>0,
                    ]);
                }
            }else if($content['category']=='direct_call:accept'){
                $call=CallRecord::where('call_id', $content['direct_call']['call_id'])->first();

                $call->update([
                    'start'=>$content['occurred_at']
                ]);

            }
            else if($content['category']=='direct_call:end'){
                $call=CallRecord::with(['caller', 'callee'])->where('call_id', $content['direct_call']['call_id'])->first();
                if($call && $call->start > 0){
                    $minutes=ceil(intval(($content['occurred_at'])-$call->start)/60000);
                    if($call->caller->account_type=='ADMIN'){
                        $rate=$call->caller->rate;
                        $sender_id=$call->callee->id;
                        $receiver_id=$call->caller->id;
                        $name=$call->caller->name;
                    }else{
                        $rate=$call->callee->rate;
                        $sender_id=$call->caller->id;
                        $receiver_id=$call->callee->id;
                        $name=$call->callee->name;
                    }

                    $call->update([
                        'end'=>$content['occurred_at'],
                        'minutes'=>$minutes,
                        'coins'=>$rate*$minutes,
                    ]);

                    //deduct balance from wallet
                    CoinWallet::create([
                        'sender_id'=>$sender_id,
                        'receiver_id'=>$receiver_id,
                        //'gift_id'=>$gift->id,
                        'message'=>'Call with '.$name,
                        'coins'=>$rate*$minutes,
                    ]);

                }
            }


        }

    }
}
