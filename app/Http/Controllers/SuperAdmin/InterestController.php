<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function index(Request $request){
        $interests=Interest::orderBy('id', 'DESC');

        if(isset($request->search)) {
            $interests=$interests->where('name', 'LIKE', '%' . $request->search . '%');

        }

        $interests=$interests->paginate(10);
        return view('admin.interest.view',['interests'=>$interests]);
    }


    public function create(Request $request){
        return view('admin.interest.add');
    }

    public function store(Request $request){
        $request->validate([
            'isactive'=>'required',
            'name'=>'required',
            //'coins'=>'required',
            'image'=>'required|image'
        ]);

        if($interest=Interest::create($request->only('name','isactive')))
        {
            $interest->saveImage($request->image, 'interest');
            return redirect()->route('interest.list')->with('success', 'Gifts has been created');
        }
        return redirect()->back()->with('error', 'Gifts create failed');
    }

    public function edit(Request $request,$id){
        $interest = Interest::findOrFail($id);
        return view('admin.interest.edit',['interest'=>$interest]);
    }

    public function update(Request $request,$id){
        $request->validate([
            'isactive'=>'required',
            'name'=>'required',
            'image'=>'image'
        ]);
        $interest = Interest::findOrFail($id);

        if($interest->update($request->only('name','coins','isactive')))
            if($request->image){
                $interest->saveImage($request->image, 'interest');
            }

        {

            return redirect()->route('interest.list')->with('success', 'gift has been updated');
        }
        return redirect()->back()->with('error', 'gift update failed');

    }


   /* public function delete(Request $request, $id){
        Gift::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Gift has been deleted');
    }*/
}

