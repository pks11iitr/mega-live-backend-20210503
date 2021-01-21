<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request){

        $gifts=Gift::where(function($gifts) use($request){
            $gifts->where('name','LIKE','%'.$request->search.'%');
        });

        $gifts=$gifts->paginate(10);
        return view('admin.gift.view',['gifts'=>$gifts]);
    }


    public function create(Request $request){
        return view('admin.gift.add');
    }

    public function store(Request $request){
        $request->validate([
            'isactive'=>'required',
            'name'=>'required',
            'coins'=>'required',
            'image'=>'required|image'
        ]);

        if($gift=Gift::create($request->only('name','coins','isactive')))
        {
            $gift->saveImage($request->image, 'gifts');
            return redirect()->route('gift.list')->with('success', 'Gifts has been created');
        }
        return redirect()->back()->with('error', 'Gifts create failed');
    }

    public function edit(Request $request,$id){
        $gift = Gift::findOrFail($id);
        return view('admin.gift.edit',['gift'=>$gift]);
    }

    public function update(Request $request,$id){
        $request->validate([
            'isactive'=>'required',
            'name'=>'required',
            'coins'=>'required',
            'image'=>'image'
        ]);
        $gift = Gift::findOrFail($id);

        if($gift->update($request->only('name','coins','isactive')))
            if($request->image){
                $gift->saveImage($request->image, 'gifts');
            }

        {

            return redirect()->route('gift.list')->with('success', 'gift has been updated');
        }
        return redirect()->back()->with('error', 'gift update failed');

    }


   /* public function delete(Request $request, $id){
        Gift::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Gift has been deleted');
    }*/
}

