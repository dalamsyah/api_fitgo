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

$router->get('welcome', function () {
    return 'Hello World';
});

$router->post("/register", "AuthController@register");
$router->post("/login", "AuthController@login");
$router->get("/users", "AuthController@index");

//master
$router->get("/master", "MasterController@getMaster");
$router->get("/tes", "MasterController@tes");

//transaction
$router->post("/save", "TransactionController@save");
$router->post("/order", "TransactionController@getUpdateOrder");
$router->get("/orders", "TransactionController@getOrders");

$router->post("/updateorderuser", "TransactionController@postUpdateOrder");
$router->post("/updateorderfailed", "TransactionController@postUpdateOrderFailed");
$router->post("/updatestatus", "TransactionController@postUpdateOrderWithStatus");

//pdf
$router->get("/cetak", "PDFController@cetak");
$router->get("/sendemail", "EmailController@sendemail");

//email
$router->get("/email", "EmailController@view");
$router->get("/sendverifikasi", "EmailController@sendverifikasi");

//verifikasi
$router->get("/verifikasi", "VerifikasiController@verifikasi");




