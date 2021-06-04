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
Route::get('/importations', 'ImportationsController@index');

// retourne les filtres sur les données de la douanes
Route::get('/filtres/douane', 'FiltreDouaneController@index'
);

// Protection des routes avec un user qui n'a pas le bon tokens
/*Route::group(['middleware' => ['auth:sanctum']], function () {
    //Route::get('/importations', 'ImportationsController@index');
    Route::post('/logout', 'AuthController@logout');
}); */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


