<?php

namespace App\Http\Controllers\MobileApps\Auth;

use App\Events\CustomerRegistered;
use App\Models\Country;
use App\Models\Customer;
use App\Models\OTPModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Email\ConnectExpress;

class RegisterController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
            //'mobile'=>['required', 'string', 'max:10'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
         $country=Country::where('id',$data['country'])->first();

       
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            //'mobile'=>$data['mobile'],
            'country'=>$country->id,
            'country_flag'=>$country->image,
            'regno'=>date("dHms") .rand(1,100000),
            'account_type'=>(($data['user_type']??'')=='admin')?'ADMIN':'USER'
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if(Customer::where('email', $request->email)->first()){
            return [
                'status'=>'failed',
                'message'=>'Email already registered. Please login to continue'
            ];
        }
         $user = $this->create($request->all());
       
        if($user->status==0){
            $otp=OTPModel::createOTP('customer', $user->id, 'register');
            $msg=str_replace('{{otp}}', $otp, config('sms-templates.register'));
            ConnectExpress::send($user->email,$msg);
           // return ['status'=>'success', 'message'=>'otp verify', 'token'=>''];
        }
        event(new CustomerRegistered($user)); 
        return [
            'status'=>'success',
            'message'=>'Please verify otp to check your spam folder of your email'
        ];
    }
}
