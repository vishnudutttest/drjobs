<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\PostCategory;
class PostCategorytable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $result = DB::table('post_category')->insert([
            'title' => 'Category 1',
        ]);
        //print_r($result);

        DB::table('post_category')->insert([
            'title' => 'Category 2',
        ]);
        DB::table('post_category')->insert([
            'title' => 'Category 3',
        ]);
        DB::table('post_category')->insert([
            'title' => 'Category 4',
        ]);
        DB::table('post_category')->insert([
            'title' => 'Category 5',
        ]);
        DB::table('post_category')->insert([
            'title' => 'Category 6',
        ]);
        //die('test');
    }
}
