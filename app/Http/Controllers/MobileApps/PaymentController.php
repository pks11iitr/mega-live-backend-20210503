<?php

namespace App\Http\Controllers\MobileApps;

use App\Events\OrderConfirmed;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\CoinWallet;
use App\Models\Payment;
use App\Services\Notification\FCMNotification;
use App\Services\Payment\RazorPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(RazorPayService $pay){
        $this->pay=$pay;
    }

    public function initiateCoinPayment(Request $request, $plan_id){ 
         //$request->status; 
        //return $request->orderid; die;
        $user=auth()->guard('customerapi')->user();
        $user=$user->id ?? 2;
        $plan=Coin::active()->findOrFail($plan_id);
        $refid=env('MACHINE_ID').time();
        $payment=Payment::create([
            'refid'=>$refid,
            'user_id'=>$user,
            'amount'=>$plan->price,
            'entity_type'=>'App\Models\Coin',
            'entity_id'=>$plan->id,
            'is_complete'=>$request->status,
            'order_id'=>$request->orderid
        ]);
        if($payment){
         return [
                'status'=>'success',
                'message'=> 'Congratulations! Your coin purchase Successfully',
                'data'=>[
                    'ref_id'=>$payment->refid,
                    'payment_id'=>$payment->id,
                    'orderid'=>$request->orderid
                ]
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Payment cannot be initiated',
                'data'=>[
                ],
            ];
        }

        //return $this->initiateGatewayPayment($payment);

    }

    private function initiateGatewayPayment($payment){
        $data=[
            "amount"=>$payment->amount*100,
            "currency"=>"INR",
            "receipt"=>$payment->refid,
        ];

        $response=$this->pay->generateorderid($data);

        $responsearr=json_decode($response);
        //var_dump($responsearr);die;
        if(isset($responsearr->id)){
            $payment->rp_order_id=$responsearr->id;
            $payment->rp_order_response=$response;
            $payment->save();
            return [
                'status'=>'success',
                'message'=>'success',
                'data'=>[
                    'payment_done'=>'no',
                    'razorpay_order_id'=> $payment->rp_order_id,
                    'total'=>$payment->amount*100,
                    'email'=>$user->email??'',
                    'mobile'=>$user->mobile??'',
                    'description'=>'Coin Purchase at '.env('APP_USER_PREFIX'),
                    'name'=>$user->name??'',
                    'currency'=>'INR',
                    //'merchantid'=>$this->pay->merchantkey,
                ],
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Payment cannot be initiated',
                'data'=>[
                ],
            ];
        }
    }

    public function verifyPayment(Request $request){

        $request->validate([
            'razorpay_order_id'=>'required',
            'razorpay_signature'=>'required',
            'razorpay_payment_id'=>'required'

        ]);

        $payment=Payment::where('rp_order_id', $request->razorpay_order_id)->first();

        if(!$payment || $payment->is_complete!=0)
            return [
                'status'=>'failed',
                'message'=>'Invalid Operation Performed'
            ];

        $plan=Coin::active()->findOrFail($payment->entity_id);

        $paymentresult=$this->pay->verifypayment($request->all());
        if($paymentresult) {
            $payment->is_complete = true;
            $payment->rp_payment_id = $request->razorpay_payment_id;
            $payment->rp_payment_response = $request->razorpay_signature;
            $payment->save();

            CoinWallet::create([
                'receiver_id'=>$payment->user_id,
                'coins'=>$plan->coin,
                'message'=>'Coin Purchase'
            ]);

            event(new OrderConfirmed($payment));

            return [
                'status'=>'success',
                'message'=> 'Congratulations! Your coin purchase at '.env('APP_USER_PREFIX').' is successful',
                'data'=>[
                    'ref_id'=>$payment->refid,
                    'order_id'=>$payment->id,
                    'refid'=>$payment->refid,
                ]
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'We apologize, Your payment cannot be verified',
                'data'=>[

                ],
            ];
        }
    }
    
    
    
   
    
    
    
    
    
    
    

}
