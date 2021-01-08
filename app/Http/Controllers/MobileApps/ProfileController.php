<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\AttendedLavel;
use App\Models\City;
use App\Models\Country;
use App\Models\Document;
use App\Models\Education;
use App\Models\Employment;
use App\Models\EthniCity;
use App\Models\FamilyPlan;
use App\Models\Height;
use App\Models\Income;
use App\Models\Kid;
use App\Models\Languages;
use App\Models\Membership;
use App\Models\Ocupation;
use App\Models\Politics;
use App\Models\State;
use App\Models\Religion;

use Illuminate\Http\Request;

class ProfileController extends Controller
{


    public function getprofile(Request $request){
        $user=$request->user;
        $profile=array(
                      'id'=>$user->id,
                      'image'=>$user->image,
                      'gender'=>$user->gender,
                      'age'=>$user->dob,
                      'mobile_no'=>$user->mobile,
                      'email'=>$user->email,
                      'address'=>$user->address,
                      'about_me'=>$user->about_me,
                      'height'=>$user->Height->name??'',
                      'ethnicity'=>$user->Ethnicity->name??'',
                      'kid'=>$user->Kids->name??'',
                      'family_plan'=>$user->Family->name??'',
                      'work'=>$user->Work->name??'',
                      'job'=>$user->Job->name??'',
                      'education'=>$user->Education->name??'',
                      'attendedlavel'=>$user->AttendedLavel->name??'',
                      'religion'=>$user->Religion->name??'',
                      'Politics'=>$user->Politics->name??'',
                       'drinking'=>$user->drinking,
                       'smoking'=>$user->smoking,
                       'marijuana'=>$user->marijuana,
                       'drugs'=>$user->drugs,
                       'age_show'=>$user->age_show,
                       'distance_show'=>$user->distance_show,

            );

        $height=Height::select('name', 'id')->get();
        ///  $language=Languages::select('name', 'id')->get();
        // $country=Country::with('states.cities')->select('name', 'id')->get();
//        $state=State::select('name', 'id')->get();
        $ethnicity=EthniCity::select('name', 'id')->get();
        $kids=Kid::select('name', 'id')->get();
        $familyplan=FamilyPlan::select('name', 'id')->get();
        $occupation=Ocupation::select('name', 'id')->get();
        $employment=Employment::select('name', 'id')->get();
        $education=Education::select('name', 'id')->get();
        $attended=AttendedLavel::select('name', 'id')->get();
        $politics=Politics::select('name', 'id')->get();

        // $income=Income::select('name', 'id')->get();
        $religion=Religion::select('name', 'id')->get();
        $marital=config('myconfig.marrital');

        return [

            'status'=>'success',
            'message'=>'',
            'profile'=>$profile,
            'data'=>compact('height','ethnicity','kids','familyplan','occupation','employment','education','attended', 'religion', 'politics','marital')

        ];


    }

    public function settings(Request $request){
        $user=$request->user;

        $memberships=Membership::active()
            ->select('title', 'description', 'price')
            ->get();

        return [

            'status'=>'success',
            'message'=>'',
            'data'=>compact('user', 'memberships')


        ];

    }

//get user images
    public function picures(Request $request){
        $user=$request->user;

        $images=$user->gallery()->select('id', 'file_path')->get();
        return [
            'status'=>'success',
            'message'=>'',
            'data'=>compact('images')
        ];
    }

//upload user images
    public function uploadpictures(Request $request){

        $request->validate([
            'images'=>'required|array',
        ]);

        $user=$request->user;
        foreach($request->images as $image)
            $user->saveDocument($image,'profile');

        $images=$user->gallery()->select('id', 'file_path')->get();

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>compact('images')
        ];
    }
//delete pic
    public function deletepic(Request $request, $id){
        $user=$request->user;
        Document::where('id', $id)
            ->where('entity_type', 'App\Models\Customer')
            ->where('entity_id', $user->id)
            ->delete();

        $images=$user->gallery()->select('id', 'file_path')->get();

        return [
            'status'=>'success',
            'message'=>'',
            'data'=>compact('images')
        ];
    }
//update picture on profile pic
    public function updateProfilePic(Request $request, $id){
        $user=$request->user;
        $document=Document::where('id', $id)
            ->where('entity_type', 'App\Models\Customer')
            ->where('entity_id', $user->id)
            ->first();
        if(!$document)
            return [
                'status'=>'failed',
                'message'=>'invalid request',
                'data'=>[]
            ];

        $user->image=$document->getOriginal('file_path');
        $user->save();
        return [
            'status'=>'success',
            'message'=>'success',
            'data'=>[]
        ];
    }


    public function updateBasicInfo(Request $request){

        $request->validate([
            'gender'=>'required|in:Male,Female',
            'height_id'=>'required|integer',
            'country_id'=>'required|integer',
            'state_id'=>'required|integer',
            'city_id'=>'required|integer',
            'pincode'=>'required|integer',
            'day'=>'required',
            'month'=>'required',
            'year'=>'required',
        ]);

        $date=$request->year.'-'.$request->month.'-'.$request->day;
        $result=$request->user->update(array_merge($request->only('gender', 'height_id', 'country_id', 'state_id', 'city_id', 'pincode'), ['dob'=>$date]));
        if($result){
            return [
                'status'=>'success',
                'message'=>'Profile Has Been Updated',
                'data'=>[]
                ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Something Went Wrong. Please Try Again',
                'data'=>[]
            ];
        }

    }

    public function updateWorkInfo(Request $request){

        $request->validate([
            'education_id'=>'required|integer',
            'occupation_id'=>'required|integer',
            'employement_id'=>'required|integer',
            'salary_id'=>'required|integer',
        ]);

            $result=$request->user->update($request->only('education_id', 'occupation_id', 'employement_id', 'salary_id'));
        if($result){
            return [
                'status'=>'success',
                'message'=>'Profile Has Been Updated',
                'data'=>[]
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Something Went Wrong. Please Try Again',
                'data'=>[]
            ];
        }

    }

    public function updatePersonalInfo(Request $request){

        $request->validate([
            'language_id'=>'required|integer',
            'religion_id'=>'required|integer',
            'marital_status_id'=>'required|integer',
        ]);

        $result=$request->user->update($request->only('language_id', 'religion_id', 'marital_status_id'));
        if($result){
            return [
                'status'=>'success',
                'message'=>'Profile Has Been Updated',
                'data'=>[]
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Something Went Wrong. Please Try Again',
                'data'=>[]
            ];
        }
    }


    public function updateAboutMe(Request $request){

        $result=$request->user->update($request->only('about_me'));

        if($request->image)
            $request->user->saveImage($request->image, 'customers');

        if($result){
            return [
                'status'=>'success',
                'message'=>'Profile Has Been Updated',
                'data'=>[]
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Something Went Wrong. Please Try Again',
                'data'=>[]
            ];
        }
    }

}
