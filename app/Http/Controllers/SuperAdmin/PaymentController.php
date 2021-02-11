<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request){

        if(isset($request->search)){
            $payments=Payment::where(function($payments) use ($request){

                $payments->where('refid', 'like', "%".$request->search."%")
                    ->orWhereHas('customer', function($customer)use( $request){
                        $customer->where('name', 'like', "%".$request->search."%")
                            ->orWhere('email', 'like', "%".$request->search."%")
                            ->orWhere('mobile', 'like', "%".$request->search."%");
                    });
            });

        }else{
            $payments =Payment::where('id', '>=', 0);
        }
        if(isset($request->fromdate))
            $payments = $payments->where('created_at', '>=', $request->fromdate.' 00:00:00');

        if(isset($request->todate))
            $payments = $payments->where('created_at', '<=', $request->todate.' 23:59:59');

        $payments =$payments->where('is_complete', '=', 1)->orderBy('id', 'desc')->get();

        return view('admin.payment.view',['payments'=>$payments]);
    }
}
