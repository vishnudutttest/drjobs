<?php

use Illuminate\Database\Seeder;
use App\User;
class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 500)->create();
    }
}
