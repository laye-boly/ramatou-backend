<?php

use Illuminate\Support\Facades\Route;

use App\Models\ImportationsDouane;
use App\User;
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

Route::get('/importations', function () {
    // return "y";
   return ImportationsDouane::all();

});

// Route::get('/users', function () {
//     // return "y";
//    return User::find(1);

// });

Route::get('/users', 'UserController@index'
);
