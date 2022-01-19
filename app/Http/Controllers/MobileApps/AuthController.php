<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OTPModel;
use App\Models\Customer;
use Mail;
class AuthController extends Controller
{

    public function returnuserid($email){
         $customer=CUstomer::where('email',$email)->first();
         if($customer){
            return $customer->id;
         }
    }

        public function requestOtp(Request $request)
        {
 
           $userid=$this->returnuserid($request->email); 
           $otp = rand(1000,9999);
           //Log::info("otp = ".$otp);
           $user = OTPModel::where('user_id','=',$userid)->update(['otp' => $otp]);
   
           if($user){  
               
            $to = $request->email;
            $subject = "Megha Live";
            $txt = "OTP Is ".$otp;
            //$headers="Megha Live";
            $headers = "From:".$to;
           //// "CC: anshulsinhax@gmail.com";

            mail($to,$subject,$txt,$headers);
               
               
             //mail("","My subject",$otp); 
             return response(["status" => 200, "message" => "OTP sent successfully"]);
           }
           else{
               return response(["status" => 401, 'message' => 'Invalid']);
           }
       }





       public function verifyOtp(Request $request){
    
        $user  = OTPModel::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
        if($user){
            auth()->login($user, true);
            User::where('email','=',$request->email)->update(['otp' => null]);
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response(["status" => 200, "message" => "Success", 'user' => auth()->user(), 'access_token' => $accessToken]);
        }
        else{
            return response(["status" => 401, 'message' => 'Invalid']);
        }
    }








}
