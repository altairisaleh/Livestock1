<?php

namespace App\Http\Controllers\ControllerApi;
use App\Models\Benficaryprofile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Password;
use App\Models\Answer;
use App\Models\Ask;
use App\Models\chat_ask;
use App\Models\chat_answer;
use App\Models\comment;
use App\Models\Benificary;
use App\Models\guidePost;
use App\Models\doctorPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\isEmpty;

class ControllerBenificaryApi extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }


///////////////////////////////Register Benificary ////////////////////////////////////////////


    public function FunRegister(Request $request)
    {
        $rules = [
            'phone' => 'required|numeric|digits:10|unique:benificarys',

        ];
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'phone' =>'required',
            'password' =>'required',
            'special' =>'required',
        ] , $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => "رقم الهاتف موجود مسبقا",
            ]);
        }
         $input = $request->all();
        //  $input['password'] = Hash::make( $input['password']);
         $Benificary =  Benificary::create($input);
        // $status['token'] =  $Benificary->createToken('Rania')->accessToken;
        return response()->json([
            'seccess' => 'تم التسجيل بنجاح',
            // $status
        ]);
    }
    ///////////////////////////////////// login Benificary //////////////////////////////////
    public function FunLogin(Request $request)
    {
        $Benificary = Auth::guard('Benificary');
        $Benificary = Benificary::where('phone', '=',  $request-> phone) -> where('password', '=', $request->password)->get();
          if($Benificary->count() > 0){
            session::put('phone' ,$request -> phone);
            session::put('password' ,$request -> password);
            $Benificary = Auth::guard('Benificary');
              return response()->json([
                'status' => 'تم تسجيل الدخول بنجاح',
                // 'Benificary' =>  $Benificary

                        ]);
                    }
                    else{
                                return response()->json([
                                    'status' => 'الرجاء ادخال البيانات بشكل صحيح',
                            ]);
                            }
}




    ///////////////////////////Benificary forget password/////////////////////////////////////////////
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

///////////////////////////////// Benficary Profile ///////////////////////////////////////////////

public function indexProfile(){

    // $Doctor = Auth::guard('Doctor');
    $Benificary  = Benificary::select('name','phone','password')->get();
   if($Benificary = Auth::guard('Benificary')){
    return response()->json([
        'Benificary' => $Benificary
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
    'Benificary_id' => 'required',
    'name' => 'required',
    'phone'  => 'required',
    'password' => 'required',
    // 'image' =>'required|file',
]);
$Benificary = Auth::guard('Benificary');
$Benficaryprofile = Benficaryprofile::create($input);
if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $Benficaryprofile->image = "$folder/$name.png";
}
 $Benficaryprofile->save();
return response()->json([

     'status' => true,

]);
}



//////////////////////////////// post Benificary ///////////////////////////////////////////////
public function funPost_g()
{
    $Posts = guidePost::all();
        return response()->json(
            //'status' => 'posts',
            //'posts' => $Post
            $Posts,
        );
    }

//////////////////////////////////////////
    public function funPost_d()
{
    $Posts = doctorPost::all();
        return response()->json(
            //'status' => 'posts',
            //'posts' => $Post
            $Posts,
        );
    }


/////////////////////////////////////////


    public function ShowPost_d($id)
{

    $doctorPost = doctorPost::find($id);

    if (is_null($doctorPost)) {
   return response()->json(['status' => 'Post not found']);

    }
    return response()->json(
                $doctorPost,
            );
}

/////////////////////////////////////


public function ShowPost_g($id)
{

    $guidePost = guidePost::find($id);

    if (is_null($guidePost)) {
   return response()->json(['status' => 'Post not found']);

    }
    return response()->json(
                $guidePost,
            );
}


//////////////////////////////////////  comments  ///////////////////////////////////////////

public function StoreComment(Request $request)
{
    $input = $request->all();
    $validator = Validator::make($input, [

        // 'content' => 'required',
        'post_id' => 'required',
        // 'record' => 'required',
    ]);
    $Benificary_id = Auth::guard('Benificary');
    $comment = Comment::create($input);
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $comment->record = "$folder/$name.mp3";
    }
    $comment->save();
      return response()->json([
        'status' => true,
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

//  اضافة استشارة في الداتابيز

public function storeAsk(Request $request){


    $input = $request->all();
    $validator = Validator::make($input, [
        // 'Benificary_id' => 'required',
        'title' => 'required',
        // 'content' => 'required',
        // 'image' => 'required|file',
        // 'record' => 'required|file',


    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
        ]);

    }
    else{

    $ask = Auth::guard('ask');
    //$input['user_id'] = $user->id;
    $ask = ask::create($input);
    $ask->Benificary_id = $input['Benificary_id'];
    $ask->title = $input['title'];
    // $ask->content = $input['content'];
   if($request->file("record")){
      $name = Str::random(15);
      $folder = "records";
      $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
      $ask->record = "$folder/$name.mp3";
       }
    if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $ask->image = "$folder/$name.png";
    }
    $ask->save();

      return response()->json([

         'seccess' => 'لم تتم اضافة الاستشارة',


            ]);
        }
}

public function UpdateAsk(Request $request, $id){

    $input = $request->all();
    $validator = Validator::make($input, [
        'Benificary_id' => 'required',
        'title' => 'required',
        // 'content' => 'required',
        // 'image' => 'required|file',
        // 'record' => 'required|file',

    ]);
    if ($validator->fails()) {
        return response()->json(['error' => 'لم يتم التعديل']);
    }
    $Benificary_id = Auth::guard('Benificary');
    $ask = ask::find($id);
    $ask->title = $input['title'];
    // $doctorPost->content = $input['content'];
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $ask->record = "$folder/$name.mp3";
    }
    if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $ask->image = "$folder/$name.png";
    }
    $ask->save();

    return response()->json(['seccess' => ' تم التعديل بنجاح',
]);

}



public function deleteAsk($id){
    $ask = ask::find($id);
    $ask->delete();
     return response()->json(['seccess' => ' تم حذف الاستشارة بنجاح',
    ]);

}




//////////////////////////// الرسائل الخاصه (الدردشات الخاصه)




public function saveask(Request $request)
{

    $input = $request->all();
    $validator = Validator::make($input, [

        // 'content' => 'required',
        'Benificary_id' => 'required',
        // 'record' => 'required',
    ]);
    $Benificary_id = Auth::guard('Benificary');
    $chat_ask = chat_ask::create($input);
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $chat_ask->record = "$folder/$name.mp3";
    }
    $chat_ask->save();
      return response()->json([
        'status' => true,
          ]);
}



public function showanswer(Request $request)
{
    $chat_answer = chat_answer::all();
    return response()->json($chat_answer);
}

























































































































































}
