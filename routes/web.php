<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::any('{slug}', function(){
//     return view('welcome');
// });
Route::middleware('isAdmin')->group(function(){
Route::post('app/create_tag','AdminController@addTag');
Route::post('app/edit_tag','AdminController@editTag');
Route::get('app/get_tags','AdminController@getTags');
Route::post('app/delete_tag','AdminController@deleteTag');
Route::post('app/upload','AdminController@upload');
Route::post('app/delete_image','AdminController@deleteImage');
Route::post('app/create_category','AdminController@addCategory');
Route::get('app/get_category','AdminController@getCategory');
Route::post('app/edit_category','AdminController@editCategory');
Route::post('app/delete_category','AdminController@deleteCategory');
Route::post('app/create_user','AdminController@createUser');
Route::get('app/get_users','AdminController@getUsers');
Route::post('app/edit_user','AdminController@editUser');
Route::post('app/admin_login','AdminController@adminLogin');
Route::get('app/tag/{id}','AdminController@tagDetails');
Route::post('app/create_role','AdminController@addRole');
Route::post('app/edit_role','AdminController@updateRole');
Route::get('app/get_roles','AdminController@getRole');
Route::post('app/delete_role','AdminController@deleteRole');

});
Route::post("/register","AdminController@register")->name("register");

Route::get("/logout","AdminController@logout");
Route::get('/dashboard','AdminController@index');
Route::any('{slug}','AdminController@index');
Route::any('{slug}/{id}','AdminController@index');

Route::get("/",function(){
    return redirect("/login");
});

Route::post("app/deleteUser","AdminController@deleteUser");
