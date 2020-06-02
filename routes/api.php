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
//lieux
Route::apiResources(['lieux'=>'API\EtatsController']);


//Biens
Route::apiResources(['biens'=>'API\BiensController']);
Route::get('countbiens','API\BiensController@countbiens');
Route::post('addequip','API\BiensController@addEquip');

//Typeetats
Route::apiResources(['typeetats'=>'API\TypeetatsController']);
//Type Bailleur
Route::apiResources(['typeballieurs'=>'API\TypebailleursController']);
//TypeBiens
Route::apiResources(['typebiens'=>'API\TypebiensController']);
//TypeBiens
Route::apiResources(['typeclients'=>'API\TypeclientsController']);
//Bailleurs
Route::apiResources(['bailleurs'=>'API\BailleursController']);
Route::get('countbailleurs','API\BailleursController@countbailleurs');
Route::post('countbiensbailleurs','API\BailleursController@countbiensbailleurs');


//clients
Route::apiResources(['clients'=>'API\ClientsController']);
Route::get('countclients','API\ClientsController@countclients');
//operation
Route::get('listebiens','API\OperationsController@listebiens');
Route::post('louer','API\OperationsController@louer');
Route::post('findclient','API\OperationsController@findclient');
Route::get('revoque','API\OperationsController@revoque');
Route::post('addrevoque','API\OperationsController@addRevoque');
Route::post('paiement','API\OperationsController@paiement');
Route::get('divers','API\OperationsController@divers');
Route::post('updatedivers','API\OperationsController@updatedivers');
Route::post('findoperation','API\OperationsController@findoperation');
Route::post('adddivers','API\OperationsController@addDivers');
Route::get('biensnonlouer','API\ListesController@biensnonlouer');
Route::get('bienslouer','API\ListesController@bienslouer');
Route::post('clientpaye','API\ListesController@clientpaye');
Route::post('clientnonpaye','API\ListesController@clientnonpaye');
Route::get('soldebailleur','API\ListesController@soldebailleur');
Route::get('soldealawa','API\ListesController@soldealawa');
Route::get('commission','API\ListesController@commission');
Route::get('sommeclient','API\ListesController@sommeclient');

Route::get('paiementactif','API\OperationsController@paiementactif');







