<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function category()
    {
       return  $this->hasOne('App\PostCategory','id','post_category')->withDefault();
         
    }

    public function user()
    {
       return $this->hasOne('App\User','id','user_id')->withDefault();  
    }
}
