<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::pattern('domain', 'api.myforum.local');

Route::group([
    'domain' => '{domain}',
    'namespace' => 'Api', 
    'as' => 'api.'
], function() { // api.v1.url
    Route::group([
        'prefix' => 'v1', // url경로에 /v1을 덧붙인다
        'namespace' => 'v1', 
        'as' => 'v1.'
    ], function(){
        Route::get('/', [
            'as' => 'index',
            'uses' => 'WelcomeController@index',
        ]);
    });
});
