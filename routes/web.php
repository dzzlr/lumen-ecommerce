<?php

use Illuminate\Support\Facades\Auth;

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
    return response()->json([
        'messages' => 'Your request has been successfully',
        'version' => $router->app->version()
    ]);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
    $router->post('/logout', 'AuthController@logout'); # Not Done
    
    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
        $router->get('/user-info', 'UserController@show');
        $router->put('/user-info/update', 'UserController@update');
        $router->put('/user-info/password/update', 'UserController@updatePassword');
        
        $router->group(['prefix' => 'shop'], function () use ($router) {
            $router->get('/', 'ShopController@index');
            $router->post('/create', 'ShopController@store');
            $router->delete('/delete/{id}', 'ShopController@destroy');

            $router->get('/shop-info/{id}', 'ShopController@show');
            $router->post('/shop-info/update/{id}', 'ShopController@update');
        });

        $router->group(['prefix' => 'product'], function () use ($router) {
            $router->get('/', 'ProductController@index');
            $router->post('/create', 'ProductController@store');
            $router->delete('/delete/{id}', 'ProductController@destroy');

            $router->get('/product-info/{id}', 'ProductController@show');
            $router->post('/product-info/update/{id}', 'ProductController@update');
        });
    });
});