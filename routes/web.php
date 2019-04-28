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

// user auth
Auth::routes();
//check user/admin
Route::post('/login-validate', 'LoginController@check')->name('login.validate');
// home
Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/about', 'HomeController@about')->name('home.about');

// admin dashboard
Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/admin', 'AdminController@index')->name('admin.index');
  // admin home
  Route::get('/admin/get-new-clients', 'AdminController@getNewClients')->name('admin.getNewClients');
  Route::get('/admin/get-new-blogs', 'AdminController@getNewBlogs')->name('admin.getNewBlogs');
  Route::get('/admin/get-user-counts', 'AdminController@getUserCount')->name('admin.getUserCount');
  Route::get('/admin/get-per-day', 'AdminController@getPerDay')->name('admin.getPerDay');
  // users
  Route::get('/admin/user-details', 'AdminController@userDetails')->name('admin.userDetails');
  Route::get('/admin/get-user-details', 'AdminController@getUsersInfo')->name('admin.getUsersInfo');
  Route::get('/admin/user-details/{id}/editUser', 'AdminController@editUser')->name('admin.editUser');
  Route::post('/admin/user-details/{id}', 'AdminController@updateUser')->name('admin.updateUser');
  Route::get('/admin/user-details/{id}/deleteUser', 'AdminController@deleteUser')->name('admin.deleteUser');
  Route::get('/admin/addUser', 'AdminController@addUser')->name('admin.addUser');
  Route::post('/admin/storeUser', 'AdminController@storeUser')->name('admin.storeUser');
  // blogs
  Route::get('/admin/blog-details', 'AdminController@blogDetails')->name('admin.blogDetails');
  Route::get('/admin/get-blog-details', 'AdminController@getBlogsInfo')->name('admin.getBlogsInfo');
  Route::get('/admin/blog-details/{id}/editBlog', 'AdminController@editBlog')->name('admin.editBlog');
  Route::post('/admin/blog-details/{id}', 'AdminController@updateBlog')->name('admin.updateBlog');
  Route::get('/admin/blog-details/{id}/deleteBlog', 'AdminController@deleteBlog')->name('admin.deleteBlog');
});

// blogs
Route::resource('blog', 'BlogsController');
Route::get('/myblogs', 'BlogsController@userBlogs')->name('blogs.userBlogs');

// campaigns
Route::resource('campaign', 'CampaignsController');

// user dashboard
Route::get('/{url}', 'DashboardController@index')->name('dashboard');
Route::get('/user/{id}/edit', 'DashboardController@edit')->name('dashboard.edit');
Route::post('/user/{id}', 'DashboardController@update')->name('dashboard.update');
