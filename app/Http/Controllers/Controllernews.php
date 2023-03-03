<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Manager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use PhpParser\Comment\Doc;
class Controllernews extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){

    }
////////////////////////////// showposts //////////////////////////////
//     public function showposts(){

//         // if (!session()-> has('password')) {return redirect()->route('admin.login');}

//         if (!Session()-> has('password'))
//   {
//     return redirect() -> route('login') ;
//    }
//     $post = Post::all();
//    return view('admin.posts.show',compact('post'));
// }

////////////////////////////// deletepost //////////////////////////////

// public function deletePost($id){

//     $post = post::find($id);
//     $post->delete();
//     return redirect()-> route('showposts');

// }

////////////////////////////// loginManager //////////////////////////////
public function login(){
    return view('admin.binfit.login');
}


public function CreateLogin(Request $request){

    // where(['phone' => $request-> phone,'password' => $request->password]) -> get();


    // remember_me
    // $remember_me = $request->has('remember_me')? true:false;
    $manager = Manager::where('phone', '=',  $request-> phone) -> where('password', '=', $request->password)->get();

          if($manager->count() > 0){
            session::put('phone' ,$request -> phone);
            session::put('password' ,$request -> password);
         return redirect()->route('admin.home');
        }

          if($manager->count() == 0){
            return redirect() -> back() -> with(['error'=>' أدخل البيانات بشكل صحيح ']);

          }

  }
//////function exit


                    public function funExit(){

                    session()->forget('password');

                    return redirect()->route('login');
                    }

}
