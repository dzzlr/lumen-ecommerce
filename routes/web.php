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
    return response()->json([
        'messages' => 'Your request has been successfully',
        'version' => $router->app->version()
    ]);
});

// $router->get('/user/{nama}', 'LoginController@get_nama');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
    // $router->get('/user', 'AuthController@getUser');
    
    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
        // $router->get('/users', function() {
        //     $users = App\Models\User::all();
        //     return response()->json($users);
        // });

        $router->group(['prefix' => 'product'], function () use ($router) {
            $router->get('/', 'ProductController@index');
            $router->post('/', 'ProductController@store');
        });
    });
});
// $router->get('/user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@get_user']);
