<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchesController extends Controller
{
    public function findMatches(Request $request){

        $user=$request->user;

        $profiles=Customer::select('id', 'name','image', 'dob')->where('id', '!=', $user->id);

        if($user->pref_gender=='Male')
            $profiles=$profiles->where('gender', 'Male');
        else
            $profiles=$profiles->where('gender', 'Female');

        if($user->from_height && $user->to_height){
            $profiles=$profiles->whereHas('height', function($height)use($user){
                $height->where('numeric_height', '>=', $user->from_height)->where('numeric_height', '<=', $user->to_height);
            });
        }

        if($user->from_age){
            $profiles=$profiles
                ->whereNotNull('dob')
                ->where(DB::raw("DATEDIFF('".date('Y-m-d')."', dob ) / 365"), '>=', $user->from_age);
        }

        if($user->to_age){
            $profiles=$profiles
            ->whereNotNull('dob')
                ->where(DB::raw("DATEDIFF('".date('Y-m-d')."', dob ) / 365"), '<=', $user->to_age);
        }

        $profiles=$profiles->paginate(4);

        return [

            'status'=>'success',
            'message'=>'',
            'data'=>compact('profiles')


        ];


    }
}
