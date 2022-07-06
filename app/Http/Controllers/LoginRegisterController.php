<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
class LoginRegisterController extends Controller
{
    
    function ajaxLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',   // required and email format validation
            'password' => 'required', // required and number field validation

        ]); 
        if ($validator->fails())   
        {
            return response()->json($validator->errors(),422);  
            // validation failed return with 422 status

        } else {
            //validations are passed try login using laravel auth attemp
            if (Auth::attempt($request->only(["email", "password"]))) {

                // check for the user is approved from admin
                if(Auth::user()->type == 2 && Auth::user()->approvedByAdmin == 0){
                    Auth::logout();
                    return response()->json(["status"=>false,'message'=>"Not approved by Admin"]);
                }
                return response()->json(["status"=>true,"redirect_location"=>$this->getRedirectUrl()]);
            } else {
                return response()->json(["status"=>false,'message'=>"Worng cerdentials"]);
            }
        }
    }

    function ajaxRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',  
            'password' => 'required|min:8', 
            'password_confirmation' => 'required|same:password',

        ]); 
        if ($validator->fails())   
        {
            return response()->json($validator->errors(),422);  
          
        } else {
           
            $User = new User;
            $User->name = $request->name;
            $User->email = $request->email;
            $User->password = bcrypt($request->password);
            $User->type = 2;
            $User->approvedByAdmin = 0;
            $User->save();
            return response()->json(["status"=>true,"msg"=>"You have successfully registered,wait till Approve"]);  
           
        }
    }

    function logout(){
        Auth::logout();
        return redirect("login")->with('success', 'Logout successfully');;
    }
    function getRedirectUrl()
    {
        if (Auth::guard()->check() && Auth::user()->type == 1 ) {
            return url('admin/dashboard');
        } elseif(Auth::guard()->check() && Auth::user()->type == 2 && Auth::user()->approvedByAdmin == 1){
            return url('user/dashboard');
        }
    }
}
