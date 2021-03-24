<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\CallRecord;
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
                if($caller && $callee){
                    CallRecord::create([
                        'call_id'=>$content['direct_call']['call_id'],
                        'caller_id'=>$caller->id,
                        'callee_id'=>$callee->id,
                        'type'=>'CALL',
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
                if($call){
                    $minutes=round(intval(($content['occurred_at'])-$call->start)/60);
                    if($call->caller->account_type=='ADMIN'){
                        $rate=$call->caller->rate;
                    }else{
                        $rate=$call->callee->rate;
                    }

                    $call->update([
                        'end'=>$content['occurred_at'],
                        'minutes'=>$minutes,
                        'coins'=>$rate*$minutes,
                    ]);

                }
            }


        }

    }
}
