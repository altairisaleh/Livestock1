<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Benificary;
use App\Models\doctorPost;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use PhpParser\Comment\Doc;

class Controllerdoctor extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){

    }

 public function home(){

  if (!Session()-> has('password'))
  {
    return redirect() -> route('login') ;
   }

    return view(view:'admin.home');
 }





    public function create(){

      // if (!session()-> has('password')) {return redirect()->route('admin.login');}
      if (!Session()-> has('password'))
  {
    return redirect() -> route('login') ;
   }

        return view(view:'admin.doctor.create');
      }

      public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:100|unique:doctors',
            'phone'=> 'required|numeric|digits:10|unique:doctors',
            'password' =>'required',
            'special' =>'required',
        ];
$messages = [
    'name.required'=>'الاسم مطلوب',
    'name.max'=>'الاسم اطول من 100 حرف',
    'name.unique'=>'الاسم موجود مسبقا',
    'phone.required'=>'رقم الهاتف مطلوب',
    'phone.max'=>'رقم الهاتف اطول من 10 ارقام',
    'phone.unique'=>'رقم الهاتف موجود مسبقا',
    'password.required'=>'كلمة المرور مطلوبة',
    'special.required'=>'التخصص مطلوب',
    'numeric'=>'  رقم الهاتف يجب ان يكون أرقام فقط',
    'digits'=>"رقم الهاتف اكبر من 10 ارقام",

];


     $validator = Validator::make($request->all(),$rules,$messages);

    //   if($validation->fails()){
    //     return redirect()->back()->withErrors($validation)->withInput($request->all());
    //   }

    if($validator->fails()){
        return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all());
    }
      //insert
      $input = $request->all();
    //   $input['password'] = Hash::make( $input['password']);
      $doctor = Doctor::create($input);
    //  $status['token']=$doctor->createToken('Rania')->accessToken;
    //  $status['name'] = $doctor->name;
        return redirect()->back()->with([$status , 'success'=>'تمت اضافة الطبيب ']);

    }

    //   public function view(){
    //     return view(view:'admin.doctor.view');
    //   }
      //show data

      public function getalldata(){

            $doctors = Doctor::select('id','name','phone','password','special')->get();
            return view('admin.doctor.view',compact('doctors'));
      }

      public function edit($doctorr_id){
        $doctors = Doctor::find($doctorr_id);
        if(!$doctors)
        return redirect()->back();

        $doctors = Doctor::select('id','name','phone','password','special')->find($doctorr_id);

          return view('admin.doctor.edit',compact('doctors'));
      }
//this function delete doctor data by id

      public function delete($doctor_id){
        //check if offer id is exists
        $offer = Doctor::find($doctor_id);

        if(!$offer)
        return redirect()
        ->back()
        ->with(['error' => 'العنصر غير موجود']);


       $offer -> delete();
        return redirect()
        ->back()
        ->with(['successd' => 'تم الحذف بنجاح']);
      }

//this function show all data binifit
      public function viewbinfit(){
        $benfic = Benificary::select('id','name','phone','password','special')->get();
        return view('admin.binfit.view',compact('benfic'));

      }


      //this function delete Binfit
      public function binfitdelete($binfit_id){
        //check if offer id is exists
        $offer = Benificary::find($binfit_id);
        if(!$offer)
        return redirect()
        ->back()
        ->with(['error' => 'العنصر غير موجود']);


       $offer -> delete();
        return redirect()
        ->back()
        ->with(['successd' => 'تم الحذف بنجاح']);
      }



public function updatedoctor(Request $request,$doctor_id){

    $offer = Doctor::find($doctor_id);

    if(!$offer)
    return redirect()
    ->back()
    ->with(['error' => 'العنصر غير موجود']);


   $offer -> update($request->all());
    return redirect()
    ->route('admin.view')
    ->with(['successd' => 'تم التعديل بنجاح']);


}

////////////////////////////// showposts //////////////////////////////
public function showposts(){

    // if (!session()-> has('password')) {return redirect()->route('admin.login');}

    if (!Session()-> has('password'))
{
return redirect() -> route('login') ;
}
$doctorPost = doctorPost::all();
return view('admin.doctor.show',compact('doctorPost'));
}

////////////////////////////// deletepost //////////////////////////////

public function deletePost($id){

$doctorPost = doctorPost::find($id);
$doctorPost->delete();
return redirect()-> route('Posts.show');

}



}
