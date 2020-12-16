<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Education;
use App\Models\Employment;
use App\Models\Height;
use App\Models\Income;
use App\Models\Languages;
use App\Models\Ocupation;
use App\Models\State;
use App\Models\Religion;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getOptions(Request $request){

        $height=Height::select('name', 'id')->get();
        $language=Languages::select('name', 'id')->get();
        $country=Country::select('name', 'id')->get();
        $state=State::select('name', 'id')->get();
        $city=City::select('name', 'id')->get();
        $education=Education::select('name', 'id')->get();
        $occupation=Ocupation::select('name', 'id')->get();
        $employment=Employment::select('name', 'id')->get();
        $income=Income::select('name', 'id')->get();
        $religion=Religion::select('name', 'id')->get();
        $marital=config('myconfig.marrital');

        return [

            'status'=>'success',
            'message'=>'',
            'data'=>compact('height', 'language', 'country', 'state', 'city', 'education','occupation', 'employment', 'income', 'religion', 'marital')

        ];


    }
}
