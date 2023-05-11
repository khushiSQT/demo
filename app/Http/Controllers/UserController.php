<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Session;
use View;

class UserController extends Controller
{
    public function index()
    {
        $user=User::all();

        return view('users.index',compact('user'))->with('i');

    }
    public function edit($id)
    {
        $user=User::find($id);

        return view('users.edit',compact('user'));
    }
    public function update(Request $request,$id)
    {
         $user=User::find($id);
         $user->name=$request->name;
         $user->email=$request->email;
         $user->update();


         if($user)
         {
            return redirect()->route('user.index')->with('success', 'Success! User updated');
         }

    }
    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
