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

Route::prefix('v1')->group(function () {
    Route::post('login', 'Api\AuthController@login');

    Route::resource('locations', 'Api/LocationController');

    //Route::group(['middleware' => 'auth:api'], function () {

        Route::post('register', 'Api\AuthController@register');
        Route::get('refresh', 'Api\AuthController@refresh');
        Route::get('logout', 'Api\AuthController@logout');

        Route::post('getUser', 'Api\AuthController@getUser');
        Route::resource('leveles', 'Api\LevelController');
        Route::resource('categories', 'Api\CategoryController');

        Route::resource('challenges', 'Api\ChallengeController');
        Route::get('challenges/level/{level}', 'Api\ChallengeController@findByLevel');

        Route::resource('trivias', 'Api\TriviaController');
        Route::get('trivias/level/{level}', 'Api\TriviaController@findByLevel');

        Route::resource('options', 'Api\OptionController');

        Route::resource('groups', 'Api\GroupController');

        Route::resource('species', 'Api\SpecieController');
        Route::get('species/group/{group}', 'Api\SpecieController@findByGroup');

        Route::get('imagespecies/specie/{specieId}', 'Api\ImageSpecieController@findBySpecie');

        Route::resource('images', 'Api\ImageController@');
        Route::resource('users', 'Api\UserController');
        Route::get('usersmobiles', 'Api\UserController@findUserMobile');

        //Route::resource('responses', 'Api\ImageController');
        Route::get('response/thisuser/{id}', 'Api\ImageController@responseThisUser');
        Route::resource('responses', 'Api\ChallengeUserController');
        Route::post('weathers', 'Api\WeatherController@findByDates');
        //Route::get('response/{challenge_id}', 'Api\ImageController@findResponses');
    //});
});

Route::prefix('mobile')->group(function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');

    Route::resource('leveles', 'Api\LevelController');
    Route::resource('categories', 'Api\CategoryController');

    Route::resource('challenges', 'Api\ChallengeController');
    Route::get('challenges/level/{level}', 'Api\ChallengeController@findByLevel');

    Route::resource('trivias', 'Api\TriviaController');
    Route::get('trivias/level/{level}', 'Api\TriviaController@findByLevel');

    Route::resource('options', 'Api\OptionController');

    Route::resource('groups', 'Api\GroupController');

    Route::resource('species', 'Api\SpecieController');
    Route::get('species/group/{group}', 'Api\SpecieController@findByGroup');

    Route::resource('sendChallenge', 'Api\ChallengeUserController');
    Route::resource('sendImages', 'Api\ImageController');

    Route::get('imagespecies/specie/{specieId}', 'Api\ImageSpecieController@findBySpecie');

    Route::post('data', 'Api\UserController@findByUsername');
    Route::get('user', 'Api\UserController@findUserMobile');
    
    Route::resource('deleteUser3', 'Api\UserController@deleteByUserMovil');
    Route::resource('deleteUser', 'Api\UserController');

    Route::resource('userDataMovil', 'Api\UserController');



    Route::resource('imagespecies', 'Api\ImageSpecieController');
    Route::get('imagespecies/specie/{specieId}', 'Api\ImageSpecieController@findBySpecie');
});
