<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Models\User;
use Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
use App\Mail\SendEmailTest;

class AuthController extends Controller
{

    public function registration()
    {
      //  try{

            return view('auth.registration');

        // }catch(Exception $e){

        //     log::info("error in  registration" .print_r($e->getMessage() ,true));

        // }
        }


    public function postRegistration(Request $request)
   {

    try{
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',

             ]);


             $user_data = array(
                'name'=>$request->name,
                'email'=>$request->email,
                'token'=>$request->_token,
             );

             $user=new User($user_data);


             $email = $request->email;

             Mail::to($email)->send(new SendEmailTest($user));
             $user->save();



            }catch(Exception $e){

                   log::info("error in  registration" .print_r($e->getMessage() ,true));

             }
     }


     public function password(Request $request,$token)
     {


           $data=User::where('token',$token)->first();

           if($data)
           {
            return view('auth.password',compact('data'));
           }
           else
           {
            return view('auth.registration');
           }
     }
     public function passwordconfirm(Request $request,$token)

     {

        try{
        // $request->validate([
        //     'password' => 'required|confirmed|min:6',
        //     'c_password' => 'required_with:password|same:password|min:6',

        //  ]);

         $user=array(
            'password' => Hash::make($request->password),


         );

         $userdata= User::where('token',$request->token)->update($user);

       // dd($userdata);

         if($userdata)
         {
            return view("auth.login");
         }
         else{
            return view("auth.password");
         }
        }catch(Exception $e){

            log::info("error in  registration" .print_r($e->getMessage() ,true));

      }
     }

    public function index(){
        return view('auth.login');

    }
    public function postLogin(Request $request)
    {
        try{
            $credentials=$request->validate([

            'email' => 'required',
            'password' => 'required',
        ]);

        $auth = Auth::attempt($credentials);


        if(Auth::attempt($credentials))
        {

            return view('dashboard');
        }

        return view("auth.login")->withSuccess('Oppes! You have entered invalid credentials');
    }catch(Exception $e){

        log::info("error in  registration" .print_r($e->getMessage() ,true));

  }
    }
    public function dashboard(){
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect("login");
    }
    public function logout(){
        Session::flush();
        Auth::logout();

        return redirect('login')->with('success','You have been logged out');
    }
}
?>
