<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/users', 'UserController@getUsers');
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'UserController@getUsers'); // Get all users
$router->get('/users/update', 'UserController@updateUser');
});