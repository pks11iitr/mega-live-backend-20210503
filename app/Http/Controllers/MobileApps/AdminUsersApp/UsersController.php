<?php

namespace App\Http\Controllers\MobileApps\AdminUsersApp;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request){

        $users=Customer::where('account_type', 'USER')
            ->select('image', 'id','name','dob', 'country')
            ->inRandomOrder()
            ->paginate(100);

        return [
            'status'=>'success',
            'data'=>compact('users')
        ];

    }
}