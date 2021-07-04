<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// route api public non protégé
// Route::get('/importations', 'ImportationsController@index'
// );

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

// Protection des routes avec un user qui n'a pas le bon tokens
/*Route::group(['middleware' => ['auth:sanctum']], function () {
    //Route::get('/importations', 'ImportationsController@getPoidsDouanes');
    Route::post('/logout', 'AuthController@logout');
}); */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


