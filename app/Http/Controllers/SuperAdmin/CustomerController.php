<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){

        $customers=Customer::where(function($customers) use($request){
            $customers->where('name','LIKE','%'.$request->search.'%')
                ->orWhere('mobile','LIKE','%'.$request->search.'%')
                ->orWhere('email','LIKE','%'.$request->search.'%');
        });

        if($request->fromdate)
            $customers=$customers->where('created_at', '>=', $request->fromdate.'00:00:00');

        if($request->todate)
            $customers=$customers->where('created_at', '<=', $request->todate.'23:59:50');

        if($request->status)
            $customers=$customers->where('status', $request->status);

        if($request->ordertype)
            $customers=$customers->orderBy('created_at', $request->ordertype);

        $customers=$customers->paginate(10);
        return view('admin.customer.view',['customers'=>$customers]);
    }

    public function details(Request $request,$id){
        $customers = Customer::with('Height','Ethnicity','Kids','Family','Work','Job','AttendedLavel','Religion','Politics','gallery','Education')->findOrFail($id);
        return view('admin.customer.details',['customers'=>$customers]);
    }

    public function edit(Request $request,$id){
        $customers = Customer::findOrFail($id);
        return view('admin.customer.edit',['customers'=>$customers]);
    }

    public function update(Request $request,$id){
        $request->validate([
            'status'=>'required',
            'name'=>'required',
            'dob'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'image'=>'image'
        ]);

        $customers = Customer::findOrFail($id);
        if($request->image){
            $customers->update([
                'status'=>$request->status,
                'name'=>$request->name,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'city'=>$request->city,
                'state'=>$request->state,
                'image'=>'a']);
            $customers->saveImage($request->image, 'customers');
        }else{
            $customers->update([
                'status'=>$request->status,
                'name'=>$request->name,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'city'=>$request->city,
                'state'=>$request->state
            ]);
        }
        if($customers)
        {
            return redirect()->route('customer.list')->with('success', 'Customer has been updated');
        }
        return redirect()->back()->with('error', 'Customer update failed');

    }

}
