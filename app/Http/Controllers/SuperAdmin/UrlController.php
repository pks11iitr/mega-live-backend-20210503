<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function privacy(Request  $request){

        return view('admin.url.privacy-policy');
    }


    public function faq(Request  $request){

        return view('admin.url.faqs');
    }


    public function customercare(Request  $request){

        return view('admin.url.customercare');
    }

    public function about(Request  $request){

        return view('admin.url.about');
    }

    public function terms(Request $request){
        return view('admin.url.terms');
    }

}
