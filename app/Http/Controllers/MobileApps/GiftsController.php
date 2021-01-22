<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Membership;
use Illuminate\Http\Request;

class GiftsController extends Controller
{
    public function index(Request $request){

        $user=$request->user;

        $gifts=Gift::active()
            ->select('id', 'name', 'image', 'coins')
            ->get();


        return [
            'status'=>'success',
            'data'=>compact('gifts')
        ];

    }


    public function sendGift(Request $request){
        $user=$request->user;

        $gift=Gift::active()->findOrFail($request->id);



    }

}
