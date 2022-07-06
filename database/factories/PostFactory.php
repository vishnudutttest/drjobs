<?php

use Faker\Generator as Faker;
use App\User;
use App\PostCategory;
use App\Post;
$factory->define(Post::class, function (Faker $faker) {
    $status = ['draft', 'publish', 'private'];
    return [
        'title' => $faker->text(10),
        'content' => $faker->text,
        'status' => $status[rand(0,2)],
        'user_id'=>User::all()->random()->id,
        'post_category'=>PostCategory::all()->random()->id
    ];
});
