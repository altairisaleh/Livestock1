<?php

namespace App\Http\Controllers\ControllerApi;
use Illuminate\Support\Facades\Auth;
use Password;
use App\Models\Answer;
use App\Models\Ask;
use App\Models\chat_ask;
use App\Models\chat_answer;
use App\Models\Doctor;
use App\Models\doctorPost;
use App\Models\Doctorprofile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\isEmpty;

class ControllerDoctorApi extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

        public function FunLogin(Request $request)
        {


            $Doctor = Auth::guard('Doctor');
            $Doctor = Doctor::where('phone', '=',  $request-> phone) -> where('password', '=', $request->password)->get();
              if($Doctor->count() > 0){
                session::put('phone' ,$request -> phone);
                session::put('password' ,$request -> password);
                  return response()->json([
                    'seccess' => 'تم تسجيل الدخول بنجاح',


                            ]);
                        }
                        else{
                                    return response()->json([
                                        'error' => 'الرجاء ادخال البيانات بشكل صحيح',

                                ]);
                                }

    }





    ///////////////////////////Doctor forget password/////////////////////////////////////////////

    public function Get_the_code(Request $request){
        $request->validate(['phone' => 'required|phone']);

        $status = Password::sendResetLink(
            $request->only('phone')
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['status' => $status ])
                    :response()->json(['phone' => __($status)]);
    }


    public function code_confirmation(Request $request){

      if($request===Password::RESET_LINK_SENT){

        return response()->json([
            'status' => true,
        ]);

      }


    }
    ///////////////////////////////// Doctor Profile ///////////////////////////////////////

public function indexProfile(){

    // $Doctor = Auth::guard('Doctor');
    $Doctor  = Doctor ::select('name','phone','password')->get();
   if($Doctor = Auth::guard('Doctor')){
    return response()->json([
        'Doctor' => $Doctor
    ]);
   }
   else{
    return response()->json([
        'status' => false,
    ]);
   }


}


public function updateProfile(Request $request){
    $input = $request->all();
    $validator = Validator::make($input, [
    'doctor_id' => 'required',
    'name' => 'required',
    'phone'  => 'required',
    'password' => 'required',
    // 'image' =>'required|file',
]);
$Doctor = Auth::guard('Doctor');
$Doctorprofile = Doctorprofile::create($input);
if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $Doctorprofile->image = "$folder/$name.png";
}
 $Doctorprofile->save();
return response()->json([

     'status' => true,

]);
}



//////////////////////////////// post doctor ///////////////////////////////////////////

////////////////////////// عرض صفحة البوستات
public function funPost()
{
    $Posts = doctorPost::all();
        return response()->json(
            //'status' => 'posts',
            //'posts' => $Post
            $Posts,
        );
    }



public function storepost(Request $request){


    $input = $request->all();
    $validator = Validator::make($input, [
        'doctor_id' => 'required',
        'title' => 'required',
        // 'content' => 'required',
        // 'image' => 'required|file',
        // 'record' => 'required|file',


    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'لم تتم اضافة المنشور',
        ]);

    }
    else{
     $doctor_id = Auth::guard('Doctor');
    $doctorPost = Auth::guard('doctorPost');
    //$input['user_id'] = $user->id;
    $doctorPost = doctorPost::create($input);
    $doctorPost->doctor_id = $input['doctor_id'];
    $doctorPost->title = $input['title'];
    // $doctorPost->content = $input['content'];
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $doctorPost->record = "$folder/$name.mp3";
    }
    if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $doctorPost->image = "$folder/$name.png";
    }
    $doctorPost->save();

      return response()->json([

         'seccess' => ' تمت اضافة المنشور,'


            ]);
        }
}






public function ShowPost($id)
{

    $doctorPost = doctorPost::find($id);

    if (is_null($doctorPost)) {
   return response()->json(['status' => 'Post not found']);

    }
    return response()->json(
                $doctorPost,
            );
}



public function UpdatePost(Request $request, $id){

    $input = $request->all();
    $validator = Validator::make($input, [
        'doctor_id' => 'required',
        'title' => 'required',
        // 'content' => 'required',
        // 'image' => 'required|file',
        // 'record' => 'required|file',

    ]);
    if ($validator->fails()) {
        return response()->json(['error' => 'لم يتم التعديل']);
    }
    $doctorPost = Auth::guard('doctorPost');
    $doctorPost = doctorPost::find($id);
    $doctorPost->title = $input['title'];
    // $doctorPost->content = $input['content'];
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $doctorPost->record = "$folder/$name.mp3";
    }
    if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $doctorPost->image = "$folder/$name.png";
    }
    $doctorPost->save();

    return response()->json(['seccess' => ' تم التعديل بنجاح',
]);

}


public function deletePost($id){
        $doctorPost = doctorPost::find($id);
        $doctorPost->delete();
         return response()->json(['seccess' => ' تم حذف المنشور بنجاح',
        ]);

  }


  ////////////////////////////////// الاستشارات ////////////////////////////////


// عرض صفحة الاستشارات
public function funAsk()
{
    $asks = ask::all();
        return response()->json(
            //'status' => 'posts',
            //'posts' => $Post
            $asks,
        );
    }

//  الرد علي الاستشارة

public function CommentAsk(Request $request)
{
    $input = $request->all();
    $validator = Validator::make($input, [

        // 'content' => 'required',
        'ask_id' => 'required',
        // 'record' => 'required',
    ]);
    $doctor_id = Auth::guard('Doctor');
    $answer = answer::create($input);
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $answer->record = "$folder/$name.mp3";
    }
    $answer->save();
      return response()->json([
        'status' => true,
          ]);
        }





//////////////////////////// الرسائل الخاصه (الدردشات الخاصه)


public function getAsker(Request $request){

    $ask = chat_ask::select('id', 'Benificary_id', 'mesage')->where('Benificary_id', $request->Benificary_id)->get();
    if($ask->count()>0){
           return   response()->json($ask);
    }
    else{
          return response()->json([]);
    }
}


///////////////



public function saveanswer(Request $request)
{

    $input = $request->all();
    $validator = Validator::make($input, [

        // 'content' => 'required',
        'ask_id' => 'required',
        // 'record' => 'required',
    ]);
    $doctor_id = Auth::guard('Doctor');
    $chat_answer = chat_answer::create($input);
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $chat_answer->record = "$folder/$name.mp3";
    }
    $chat_answer->save();
      return response()->json([
        'status' => true,
          ]);


}










}
