<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Education;
use App\Models\Employment;
use App\Models\EthniCity;
use App\Models\Height;
use App\Models\Ocupation;
use App\Models\Religion;
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
        $customers = Customer::with('Height','Ethnicity','Work','Job','gallery','Education')->findOrFail($id);
        return view('admin.customer.details',['customers'=>$customers]);
    }
  public function images(Request  $request,$id){
      $request->validate([
          'images'=>'required|array',
      ]);
         $customer=Customer::find($id);
      foreach($request->images as $image)
          $document=$customer->saveDocument($image,'profile');
      return redirect()->back()->with('success', 'Customer images uploaded Successfully');
  }
  public function deleteimage (Request $request,$id){
      Document::where('id', $id)->delete();
      return redirect()->back()->with('success', 'Images has been deleted');

  }

    public function create(Request $request){
        $height=Height::select('name', 'id')->get();
        $ethnicity=EthniCity::select('name', 'id')->get();
        $occupation=Ocupation::select('name', 'id')->get();
        $employment=Employment::select('name', 'id')->get();
        $education=Education::select('name', 'id')->get();
        $religion=Religion::select('name', 'id')->get();
        return view('admin.customer.add',['height'=>$height,'ethnicity'=>$ethnicity,'occupation'=>$occupation,'employment'=>$employment,'education'=>$education,'religion'=>$religion]);
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
