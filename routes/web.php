<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'UserController@getUsers'); // Get all users
    $router->post('/users', 'UserController@add'); // Create a user
    $router->get('/users/{id}', 'UserController@show'); // Get user by ID
    $router->put('/users/{id}', 'UserController@update'); // Update user (PUT)
    $router->patch('/users/{id}', 'UserController@update'); // Update user (PATCH)
    $router->delete('/users/{id}', 'UserController@delete'); // Delete user
});