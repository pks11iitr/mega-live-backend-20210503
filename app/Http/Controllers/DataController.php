<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function countries(Request $request){
        $coutries=Country::select('id', 'name', 'image')->get();
        return [
            'status'=>'success',
            'data'=>compact('coutries')
        ];

    }
}
