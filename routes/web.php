<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/user', [UserController::class, 'getUser']);
// $router->get('/user',  ['user' => 'UserController@getUser']);

// $app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
// {
//   $app->get('/user','UserController@getUser');
// });

$router->get('/user/{id}', 'UserController@getUser');
$router->get('/user', 'UserController@consultaUsuario');
