<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class DatingController extends Controller
{
    public function dating(Request $request,$type){

        //$user=$request->user;

        $dating =Customer::with('countryName')
            ->select('name','image', 'dob','country', 'last_active')
            ->inRandomOrder();

        if($type=='single'){
            $dating=$dating->  where('is_single',true);

        }elseif($type=='nightstand') {
            $dating =$dating->where('night_stand',true);

        }else{
            $dating=$dating;
        }

        $dating=$dating->paginate(50);

        foreach($dating as $d)
        {
            if(date('Y-m-d H:i:s', strtotime('+1 mins',strtotime($d->last_active))>date('Y-m-d H:i:s')))
                $d->is_online=1;
            else
                $d->is_online=0;
        }

        return [
            'status'=>'success',
            'message'=>'',
            'apidata'=>compact('dating')
        ];

    }

}
