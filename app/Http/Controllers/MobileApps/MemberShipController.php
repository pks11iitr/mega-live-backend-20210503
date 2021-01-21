<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MemberShipController extends Controller
{
    public function membership(){
        $membership=Membership::active()->get();
    if($membership->count()>0)
    {
        return [
            'status'=>'success',
            'message'=>'success',
            'data'=>compact('membership')
        ];
    }else{
        return [
            'status'=>'failed',
            'message'=>'No Record Found',

        ];
    }

    }


}
