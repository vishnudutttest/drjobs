<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    //
    function index(){
        echo "User dahsboard";
    }

    //
    public function postList()
    {
        $id = Auth::user()->id;
        $posts = Post::where("user_id",$id)->paginate(10);
        return view('user.dashboard', ['posts' =>  $posts]);
    }

    public function deletePost(Request $request,$postid){
        $post = Post::find($postid);
        $this->authorize('canDelete',$post);
        
        $id = Auth::user()->id;
        if($id==$post->user_id){
            if($post->delete()){
                return ['status'=>true,'message'=>'Post Deleted Successfully '];
            }else{
                return ['status'=>false,'message'=>'Problem while deleting the Post'];
            }
        }else{
            return ['status'=>false,'message'=>'You are not the owner'];
        }
       
    }
}
