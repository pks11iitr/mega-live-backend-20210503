<?php

namespace App\Http\Controllers\MobileApps;

use App\Models\Banner;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\NewsUpdate;
use App\Models\Product;
use App\Models\Story;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(Request $request){

        $user=auth()->guard('customerapi')->user();

        $banners=Banner::active()->get();
        $profiles=Customer::with(['name', 'city',  'religion'])
            ->where('gender', ($user->gender=='Female')?'Male':'Female')
            ->whereNotNull('gender')
            //->select('name', 'city',  'religion')
            ->get();
        $stories=Story::active()->get();
        $news=NewsUpdate::active()->get();

        $user=[
            'name'=>$user->name??'',
            'image'=>$user->image??'',
            'mobile'=>$user->mobile??''
        ];

        return [
            'status'=>'success',
            'data'=>compact('profiles', 'banners',  'user', 'stories', 'news')
        ];
    }
}
