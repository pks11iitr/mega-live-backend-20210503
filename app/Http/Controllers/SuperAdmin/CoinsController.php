<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    public function index(Request $request){

        $coins=Coin::paginate(10);
        return view('admin.coins.view',['coins'=>$coins]);
    }


    public function create(Request $request){
        return view('admin.coins.add');
    }

    public function store(Request $request){
        $request->validate([
            'isactive'=>'required',
            'coin'=>'required',
            'price'=>'required',
        ]);

        if($coin=Coin::create($request->only('coin','price','isactive'))) {

            return redirect()->route('coins.list')->with('success', 'coins has been created');
        }
        return redirect()->back()->with('error', 'coins create failed');
    }

    public function edit(Request $request,$id){
        $coin = Coin::findOrFail($id);
        return view('admin.coins.edit',['coin'=>$coin]);
    }

    public function update(Request $request,$id){
        $request->validate([
            'isactive'=>'required',
            'coin'=>'required',
            'price'=>'required',
        ]);
        $coin = Coin::findOrFail($id);
        if( $coin->update($request->only('coin','price','isactive')))
        {
            return redirect()->route('coins.list')->with('success', 'coins has been updated');
        }
        return redirect()->back()->with('error', 'coins update failed');

    }


    public function delete(Request $request, $id){
        Coin::where('id', $id)->delete();
        return redirect()->back()->with('success', 'coins has been deleted');
    }
}

