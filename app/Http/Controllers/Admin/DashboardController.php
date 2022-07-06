<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use Illuminate\Support\Facades\DB;
use Auth;
class DashboardController extends Controller
{
    //
    function index(){
        $this->userIsAdmin();
        $users = DB::table('users')->paginate(10);
        return view('admin.dashboard', ['users' =>  $users]);
    }

    public function approveUser(Request $request,$id){
        $this->userIsAdmin();
       $user = User::find($id);
       $user->approvedByAdmin = 1;
       if($user->save()){
        return ['success'=>'Updated Successfully'];
       }
       return ['error'=>'error in updation'];
    }

    public function deleteUser(Request $request,$id){
        $this->userIsAdmin();
        $user = User::find($id);
        if($user->delete()){
            return ['success'=>'Deleted Successfully'];
           }
        return ['error'=>'error in deletion'];
    }

    public function getUser(Request $request,$id){
        $this->userIsAdmin();
        $user = User::find($id);
        return $user;
    }

    public function updateUser(Request $request){
        $id = $request->input('id');
        $this->userIsAdmin();
        if($id!=1){
            return ['error'=>"Please don't update Admin User "];
        }
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'id' => 'required',
        ]);
       
        if(!empty($validatedData->error))
        {
            return $validatedData;
        }
        $user = User::find($id);
        $user->name = $validatedData['name'];

        $user->email = $validatedData['email'];
        //print_r($validatedData);
        if(!empty($validatedData['password']))
        $user->password = bcrypt($validatedData['password']);
        $user->type = 2;
        if($user->save()){
            return ['success'=>'Updated Successfully'];
        }
        return ['error'=>'error in deletion'];
    }

    function userIsAdmin()
    {
       /* $curentuser = Auth::user();
        /*echo "<pre>";
        print_r($curentuser->type);
        echo "</pre>"; * /
        if($curentuser->type != 1){
            return ['error'=>"You are not autherised to delete the user"];
        }*/
        $this->authorize('isAdmin');
    }

    
}
