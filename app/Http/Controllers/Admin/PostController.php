<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Post;
class PostController extends Controller
{
    //
    public function postList()
    {
        $this->userIsAdmin();
        $posts = Post::paginate(30);
        return view('admin.post', ['posts' =>  $posts]);
    }
    
    function userIsAdmin()
    {
        /*$curentuser = Auth::user();
        /*echo "<pre>";
        print_r($curentuser->type);
        echo "</pre>";* /
        if($curentuser->type != 1){
            return ['error'=>"You are not autherised to delete the user"];
        }*/
        $this->authorize('isAdmin');
    }

    public function deletePost(Request $request,$postid){
        $post = Post::find($postid);
        if(!$this->authorize('isAdmin')){
            return ['status'=>false,'message'=>'You are not authorized for this aciton'];
        }
       
        if($post->delete()){
            return ['status'=>true,'message'=>'Post Deleted Successfully '];
        }else{
            return ['status'=>false,'message'=>'Problem while deleting the Post'];
        }
       
       
    }
}
