<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect(Request $request){

        $user=auth()->user();
        if($user->hasRole('admin')){
            return redirect('home');
        }else if($user->hasRole('caller')){
//            die('aaa');
            return redirect('caller.home');
        }else{
            Auth::logout();
            return redirect('website.home');
        }

    }
}
