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

// Unsecure API routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', ['uses' => 'UserController@getUsers']);
});

// More routes for users
$router->get('/users', 'UserController@index'); // Get all user records
$router->post('/users', 'UserController@add'); // Create a new user record
$router->get('/users/{id}', 'UserController@show'); // Get a user by ID
$router->put('/users/{id}', 'UserController@update'); // Update a user record (full update)
$router->patch('/users/{id}', 'UserController@update'); // Update a user record (partial update)
$router->delete('/users/{id}', 'UserController@delete'); // Delete a user record