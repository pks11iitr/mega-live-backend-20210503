<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    public function findMatches(Request $request){

        $user=$request->user;

        $profiles=Customer::with('city')->select('id', 'name','image', 'dob', 'city_id');

        if($user->gender=='Male')
            $profiles=$profiles->where('gender', 'Female');
        else
            $profiles=$profiles->where('gender', 'Male');

        if(!empty($request->income))
            $profiles=$profiles->where('salary_id', $request->income);
        if(!empty($request->religion))
            $profiles=$profiles->where('religion_id', $request->religion);
        if(!empty($request->city))
            $profiles=$profiles->where('city_id', $request->city);
        if(!empty($request->state))
            $profiles=$profiles->where('state_id', $request->state);
        if(!empty($request->country))
            $profiles=$profiles->where('country_id', $request->country);
        if(!empty($request->religion))
            $profiles=$profiles->where('religion_id', $request->religion);
        if(!empty($request->language))
            $profiles=$profiles->where('language_id', $request->language);
        if(!empty($request->height))
            $profiles=$profiles->where('height_id', $request->height);
        if(!empty($request->education))
            $profiles=$profiles->where('education_id', $request->education);
        if(!empty($request->occupation))
            $profiles=$profiles->where('occupation_id', $request->occupation);
        if(!empty($request->member_type))
            $profiles=$profiles->where('is_premium', $request->member_type);
        if(!empty($request->eating))
            $profiles=$profiles->where('eating', $request->eating);
        if(!empty($request->manglik))
            $profiles=$profiles->where('manglik', $request->manglik);

        $profiles=$profiles->paginate(4);

        return [

            'status'=>'success',
            'message'=>'',
            'data'=>compact('profiles')


        ];


    }
}
