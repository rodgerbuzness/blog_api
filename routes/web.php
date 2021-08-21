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


// user
$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');
$router->post('logout', 'AuthController@logout');

// post
$router->post('posts/create', [
    'middleware' => 'jwtAuth',
    'uses' => 'PostsController@create'
]);
$router->post('posts/delete', [
    'middleware' => 'jwtAuth',
    'uses' => 'PostsController@delete'
]);
$router->post('posts/update', [
    'middleware' => 'jwtAuth',
    'uses' => 'PostsController@update'
]);
$router->get('posts', [
    'middleware' => 'jwtAuth',
    'uses' => 'PostsController@posts'
]);

// comments
$router->post('comments/create', [
    'middleware' => 'jwtAuth',
    'uses' => 'CommentsController@create'
]);
$router->post('comments/delete', [
    'middleware' => 'jwtAuth',
    'uses' => 'CommentsController@delete'
]);
$router->post('comments/update', [
    'middleware' => 'jwtAuth',
    'uses' => 'CommentsController@update'
]);
$router->get('comments', [
    'middleware' => 'jwtAuth',
    'uses' => 'CommentsController@comments'
]);

// likes
$router->post('posts/like', [
    'middleware' => 'jwtAuth',
    'uses' => 'LikeController@like'
]);


