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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['user'=>'API\UserController']);
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
Route::get('countuser','API\UserController@countuser');

//equipement
Route::apiResources(['equipements'=>'API\EquipementsController']);

//Biens
Route::apiResources(['biens'=>'API\BiensController']);
Route::get('countbiens','API\BiensController@countbiens');
Route::post('addequip','API\BiensController@addEquip');

//Typeetats
Route::apiResources(['typeetats'=>'API\TypeetatsController']);
//TypeComptes
Route::apiResources(['typecomptes'=>'API\TypecomptesController']);
//TypeBiens
Route::apiResources(['typebiens'=>'API\TypebiensController']);
//TypeBiens
Route::apiResources(['typeclients'=>'API\TypeclientsController']);
//Bailleurs
Route::apiResources(['bailleurs'=>'API\BailleursController']);
Route::get('countbailleurs','API\BailleursController@countbailleurs');
//clients
Route::apiResources(['clients'=>'API\ClientsController']);
Route::get('countclients','API\ClientsController@countclients');
//operation
Route::get('listebiens','API\OperationsController@listebiens');
Route::post('louer','API\OperationsController@louer');
Route::post('findclient','API\OperationsController@findclient');

