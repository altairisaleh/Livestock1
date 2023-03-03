<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\guide;
use App\Models\guidePost;
use Illuminate\Support\Facades\Validator;
use PhpParser\Comment\Doc;

class Controllerguide extends BaseController
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

        return view(view:'admin.guide.create');
      }

      public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:100|unique:guides',
            'phone'=> 'required|numeric|digits:10|unique:guides',
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



      //insert in database
      $input = $request->all();
    //   $input['password'] = Hash::make( $input['password']);
      $guide = guide::create($input);
    //  $status['token']=$guide->createToken('Rania')->accessToken;
    //  $status['name'] = $guide->name;
        return redirect()->back()->with([$status , 'success'=>'تمت اضافة المرشد ']);

    }
    //   public function view(){
    //     return view(view:'admin.guide.view');
    //   }
      //show data

      public function getalldata(){

            $guides = guide::select('id','name','phone','password','special')->get();
            return view('admin.guide.view',compact('guides'));
      }
// edit data by id
      public function edit($guidee_id){
        $guides = guide::find($guidee_id);
        if(!$guides)
        return redirect()->back();

        $guides = guide::select('id','name','phone','password','special')->find($guidee_id);

          return view('admin.guide.edit',compact('guides'));
      }


//delete data

      public function delete($guide_id){
        //check if offer id is exists
        $offer = guide::find($guide_id);

        if(!$offer)
        return redirect()
        ->back()
        ->with(['error' => 'العنصر غير موجود']);


       $offer -> delete();
        return redirect()
        ->back()
        ->with(['successd' => 'تم الحذف بنجاح']);
      }

// update user data

public function updateguide(Request $request,$guide_id){

    $offer = guide::find($guide_id);

    if(!$offer)
    return redirect()
    ->back()
    ->with(['error' => 'العنصر غير موجود']);


   $offer -> update($request->all());
    return redirect()
    ->route('admin.guide.view')
    ->with(['successd' => 'تم التعديل بنجاح']);


}


////////////////////////////// showposts //////////////////////////////
public function showposts(){

$guidePost = guidePost::all();
return view('admin.guide.show',compact('guidePost'));
}

////////////////////////////// deletepost //////////////////////////////

public function deletePost($id){

$guidePost = guidePost::find($id);
$guidePost->delete();
return redirect()-> route('Posts.guide.show');

}




}
