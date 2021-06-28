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

$router->get('/kategori', 'Kategori\KategoriController@index');
$router->get('/kategori/{id}', 'Kategori\KategoriController@show');
$router->post('/kategori', 'Kategori\KategoriController@store');
$router->put('/kategori', 'Kategori\KategoriController@update');

$router->get('/produk', 'Produk\ProdukController@index');
$router->get('/produk/{id}', 'Produk\ProdukController@show');
$router->post('/produk', 'Produk\ProdukController@store');
$router->put('/produk', 'Produk\ProdukController@update');