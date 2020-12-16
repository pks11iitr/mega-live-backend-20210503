<?php

namespace App\Http\Controllers\MobileApps;

use App\Models\Banner;
use App\Models\Configuration;
use App\Models\Product;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Height;
use App\Models\Languages;
use App\Models\Religion;
use App\Models\Income;
use App\Models\Ocupation;
use App\Models\Employment;
use App\Models\State;
use App\Models\Education;
use App\Models\Country;
use App\Models\City;

class HomeController extends Controller
{
    public function home(Request $request){

        $user=auth()->guard('customerapi')->user();

        $banners=Banner::active()->get();
        $products=Product::active()->where('top_deal', true)->get();
        $videos=Video::active()->get();
        $services=[
            [
            'name'=>'Clinics',
            'url'=>route('clinics.list')
            ],
            [
                'name'=>'Therapies',
                'url'=>route('therapies.list')
            ],
        ];

        $user=[
            'name'=>$user->name??'',
            'image'=>$user->image??'',
            'mobile'=>$user->mobile??''
        ];

        $channel_url=Configuration::where('param', 'channel_url')->first();
        $channel_url=$channel_url->value;
        return [
            'status'=>'success',
            'data'=>compact('services','products','videos', 'banners', 'channel_url', 'user')
        ];
    }
}
