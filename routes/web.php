<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/users', 'UserController@getUsers');
$router->group(['prefix' => 'api'], function () use ($router) {
$router->get('/users', 'UserController@getUsers'); // Get all users
$router->post('/users/update', 'UserController@updateUser');
});