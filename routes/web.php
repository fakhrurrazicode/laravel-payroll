<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::get('role/select2_data', 'RoleController@select2Data')->name('role.select2Data');
    Route::get('role/table_data', 'RoleController@tableData')->name('role.tableData');
    Route::resource('role', 'RoleController');

    Route::get('permission/select2_data', 'PermissionController@select2Data')->name('permission.select2Data');
    Route::get('permission/table_data', 'PermissionController@tableData')->name('permission.tableData');
    Route::resource('permission', 'PermissionController');

    Route::get('user/select2_data', 'UserController@select2Data')->name('user.select2Data');
    Route::get('user/table_data', 'UserController@tableData')->name('user.tableData');
    Route::resource('user', 'UserController');
});
