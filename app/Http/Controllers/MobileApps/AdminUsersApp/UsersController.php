<?php

namespace App\Http\Controllers\MobileApps\AdminUsersApp;

use App\Http\Controllers\Controller;
use App\Models\CoinWallet;
use App\Models\Customer;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request){

        $users=Customer::where('account_type', 'USER')
            ->select('image', 'id','name','dob', 'country', 'last_active')
            ->orderBy('last_active', 'desc')
            ->paginate(10);

        foreach($users as $u){
            $u->balance=CoinWallet::balance($u->id);
            if(date('Y-m-d H:i:s', strtotime('+1 minutes',strtotime($u->last_active)))>date('Y-m-d H:i:s'))
                $u->is_online=1;
            else
                $u->is_online=0;
        }

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }
}
