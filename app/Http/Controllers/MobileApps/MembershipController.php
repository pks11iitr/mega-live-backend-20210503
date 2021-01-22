<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request){


        $user=auth()->guard('customerapi')->user();


        $memberships=Membership::active()->get();


        $active=[
            'plan_id'=>(($user->membership_expiry??null)>=date('Y-m-d'))?$user->active_membership:0,
            'is_active'=>(($user->membership_expiry??null)>=date('Y-m-d'))?1:0
        ];

        return [

            'status'=>'success',
            'data'=>compact('memberships', 'active')

        ];

    }
}
