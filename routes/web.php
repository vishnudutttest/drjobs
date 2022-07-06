<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/ajaxlogin', 'LoginRegisterController@ajaxLogin')->name('ajaxlogin');
Route::post('/ajaxregister', 'LoginRegisterController@ajaxRegister')->name('ajaxregister');
Route::get('/logout', 'LoginRegisterController@logout');
Auth::routes();
Route::group(['as'=>'admin.','prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('posts', 'DashboardController@post')->name('posts');
    Route::get('/users/delete/{id}', 'DashboardController@deleteUser');
    Route::get('/getuser/{id}', 'DashboardController@getUser');
    Route::post('/updateuser/', 'DashboardController@updateUser');
    Route::get('/postslist/', 'PostController@postList')->name('postslist');
    Route::get('/users/approve/{id}', 'DashboardController@approveUser');
    Route::get('/deletepost/{id}', 'PostController@deletePost');
    Route::get('/users', function (Request $request) {
        $user = DB::table('users')->paginate(10);
        return [
                    'user'=> $user,
                ];
    });
});

Route::group(['as'=>'user.','prefix' => 'user','namespace'=>'User','middleware'=>['auth','user']], function () {
    Route::get('dashboard', 'DashboardController@postList')->name('dashboard');
    Route::get('deletepost/{postid}', 'DashboardController@deletePost')->name('deletepost');
    //Route::get('dashboard', 'DashboardController@post')->name('post');
});



Route::get('/home', 'HomeController@index')->name('home');
