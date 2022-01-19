<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinWallet;
use App\Models\Customer;

class CoinAddbyAdminController extends Controller
{
    public function index(){
    $addcoins=CoinWallet::orderBy('id','desc')->paginate(10);
    return view('admin.addcoin.view',compact('addcoins'));
    }



    public function create(){
        $customers=Customer::where('status',1)->orderBy('id','desc')->get();
        return view('admin.addcoin.add',compact('customers'));
    }



    public function store(Request $request){
        
        $coins=CoinWallet::create($request->only('sender_id', 'receiver_id', 'gift_id', 'coins', 'message'));
        return redirect()->route('Admincoinadd.edit',$coins->id)->with('success','Coins Addedd Successfully');
        
    }



    public function edit($id){
        $customers=Customer::where('status',1)->orderBy('id','desc')->get();
        $addcoins=CoinWallet::findOrFail($id);
        return view('admin.addcoin.edit',compact('addcoins','customers'));
    }




    public function update(request $request,$id){
        
        $addcoins=CoinWallet::findOrFail($id);
        $addcoins->update($request->only('sender_id', 'receiver_id', 'gift_id', 'coins', 'message'));
        return redirect()->back()->with('success','update has been successfully');
    }



}
