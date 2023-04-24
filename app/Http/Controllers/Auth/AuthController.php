<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
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
         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
         ]);
         $user=new User;
         $user->name=$request->name;
         $user->email=$request->email;
         $user->password=$request->password;
         $user->save();
         return redirect('login')->withSuccess('Great! You have Successfully loggedin');
     }
    public function index(){
        return view('auth.login');
    
    }
    public function postLogin(Request $request)
    {

        $abc =$request->validate([

            'email' => 'required',
            'password' => 'required',
        ]);

        

        if(Auth::attempt($abc)){

            return redirect('dashboard');
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
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