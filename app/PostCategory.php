<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'post_category';

    protected $fillable = [
        'title'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
