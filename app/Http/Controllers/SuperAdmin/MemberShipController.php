<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MemberShipController extends Controller
{
    public function index(Request $request){

        $memberships=Membership::where(function($memberships) use($request){
            $memberships->where('title','LIKE','%'.$request->search.'%');
        });

        $memberships=$memberships->paginate(10);
        return view('admin.membership.view',['memberships'=>$memberships]);
    }


    public function create(Request $request){
        return view('admin.membership.add');
    }

    public function store(Request $request){
        $request->validate([
            'isactive'=>'required',
            'title'=>'required',
            'description'=>'required',
            'price'=>'required',
            'validity_days'=>'required'
        ]);

        if($membership=Membership::create($request->only('title','description','price','validity_days','isactive'))) {

            return redirect()->route('membership.list')->with('success', 'Membership has been created');
        }
        return redirect()->back()->with('error', 'Membership create failed');
    }

    public function edit(Request $request,$id){
        $membership = Membership::findOrFail($id);
        return view('admin.membership.edit',['membership'=>$membership]);
    }

    public function update(Request $request,$id){
        $request->validate([
            'isactive'=>'required',
            'title'=>'required',
            'description'=>'required',
            'price'=>'required',
            'validity_days'=>'required'
        ]);
        $membership = Membership::findOrFail($id);
           if( $membership->update($request->only('title','description','price','validity_days','isactive')))
        {
            return redirect()->route('membership.list')->with('success', 'membership has been updated');
        }
        return redirect()->back()->with('error', 'membership update failed');

    }


//    public function delete(Request $request, $id){
//        Membership::where('id', $id)->delete();
//        return redirect()->back()->with('success', 'membership has been deleted');
//    }
}

