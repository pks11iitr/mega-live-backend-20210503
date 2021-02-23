<?php

namespace App\Http\Controllers\CallerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){

        return view('caller-admin.home');
    }
}
