<?php

namespace App\Http\Controllers\ControllerApi;
use Auth;
use Password;
use App\Models\guideprofile;
use App\Models\Answer;
use App\Models\answers_guide;
use App\Models\Ask;
use App\Models\chat_ask;
use App\Models\chat_answer;
use App\Models\guide;
use App\Models\guidePost;
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

class ControllerguideApi extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }
    public function FunLogin(Request $request)
    {

        $guide = Auth::guard('guide');
        $guide = guide::where('phone', '=',  $request-> phone) -> where('password', '=', $request->password)->get();
          if($guide->count() > 0){
            session::put('phone' ,$request -> phone);
            session::put('password' ,$request -> password);
              return response()->json([
                'status' => 'تم تسجيل الدخول بنجاح',

                        ]);
                    }
                    else{
                                return response()->json([
                                    'status' => 'الرجاء ادخال البيانات بشكل صحيح',

                            ]);
                            }

     }


    ///////////////////////////guide forget password/////////////////////////////////////////////

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

//////////////////////////////////////// guide Profile /////////////////////////////////
public function indexProfile(){

    $guide  = guide ::select('name','phone','password')->get();
   if($guide = Auth::guard('guide')){
    return response()->json([
        'guide' => $guide
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
    'guide_id' => 'required',
    'name' => 'required',
    'phone'  => 'required',
    'password' => 'required',
    // 'image' =>'required|file',
]);
$guide = Auth::guard('guide');
$guideprofile = guideprofile::create($input);
if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $guideprofile->image = "$folder/$name.png";
}
 $guideprofile->save();
return response()->json([

     'status' => true,

]);
}


//////////////////////////////// post guide ///////////////////////////////////////////
public function funPost()
{
    $Posts = guidePost::all();
        return response()->json(
            //'status' => 'posts',
            //'posts' => $Post
            $Posts,
        );
    }

    public function storepost(Request $request){


        $input = $request->all();
        $validator = Validator::make($input, [
            'guide_id' => 'required',
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

        $guidePost = Auth::guard('guidePost');
        //$input['user_id'] = $user->id;
        $guidePost = guidePost::create($input);
        $guidePost->guide_id = $input['guide_id'];
        $guidePost->title = $input['title'];
        // $guidePost->content = $input['content'];
        if($request->file("record")){
        $name = Str::random(15);
        $folder = "records";
        $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
        $guidePost->record = "$folder/$name.mp3";
        }
        if($request->file("image")){
        $name = Str::random(15);
        $folder = "images";
        $image = $request->file('image')->storeAs("public/$folder", "$name.png");
        $guidePost->image = "$folder/$name.png";
        }
        $guidePost->save();

          return response()->json([

             'status' => true,
             'Post Added Successfully!'

                ]);
            }
    }


    public function ShowPost($id)
{

    $guidePost = guidePost::find($id);

    if (is_null($guidePost)) {
   return response()->json(['status' => 'Post not found']);

    }
    return response()->json(
                $guidePost,
            );
}



public function UpdatePost(Request $request, $id){

    $input = $request->all();
    $validator = Validator::make($input, [
        'guide_id' => 'required',
        'title' => 'required',
        // 'content' => 'required',
        // 'image' => 'required|file',
        // 'record' => 'required|file',

    ]);
    if ($validator->fails()) {
        return response()->json(['status' => 'no post updated']);
    }
    $guidePost = Auth::guard('guidePost');
    $guidePost = guidePost::find($id);
    $guidePost->title = $input['title'];
    // $guidePost->content = $input['content'];
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $guidePost->record = "$folder/$name.mp3";
    }
    if($request->file("image")){
    $name = Str::random(15);
    $folder = "images";
    $image = $request->file('image')->storeAs("public/$folder", "$name.png");
    $guidePost->image = "$folder/$name.png";
    }
    $guidePost->save();

    return response()->json($guidePost);
}



public function deletePost($id){
    $guidePost = guidePost::find($id);
    $guidePost->delete();
     return response()->json(['status' => ' post deleted successfuly',
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
    $guide_id = Auth::guard('guide');
    $answers_guide = answers_guide::create($input);
    if($request->file("record")){
    $name = Str::random(15);
    $folder = "records";
    $record = $request->file('record')->storeAs("public/$folder", "$name.mp3");
    $answers_guide->record = "$folder/$name.mp3";
    }
    $answers_guide->save();
      return response()->json([
        'status' => true,
          ]);
        }


////////////////////////////////////////////////////////////////////////////////////////////






















}
