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

Route::get('/', 'WelcomeController@index'
);

Route::post('/register', 'AuthController@register'
);
Route::post('/login', 'AuthController@login'
);
Route::get('/importations/douanes', 'ImportationsController@getPoidsDouanes');
Route::get('/nombre/conteneur/douanes', 'ImportationsController@getNombreConteneurDouanes');
Route::get('/temps/voyage/douanes', 'ImportationsController@getTravelTimeDouane');
Route::get('/importations/bsc', 'ImportationsController@getPoidsBSC');
Route::get('/nombre/conteneur/bsc', 'ImportationsController@getNombreConteneurBSC');
Route::get('/nombre/vehicule/bsc', 'ImportationsController@getNombreVehiculeBSC');
Route::get('/fret/bsc', 'ImportationsController@getFretBSC');

// retourne les filtres sur les données de la douanes
Route::get('/filtres/douanes', 'FiltreController@getFiltreDouanes');
Route::get('/filtres/bsc', 'FiltreController@getFiltreBSC');


// Route::get('/users', 'ImportationsController@index'
// );

// Route::get('/', function () {
//     return view('welcome');
// });






