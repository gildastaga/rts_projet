<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

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
    $data = [
        'name' => config('app.name'),
        'version' => config('app.version'),
        'framework' => $router->app->version(),
        'environment' => config('app.env'),
        'debug_mode' => config('app.debug'),
        'timestamp' => Carbon::now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ];
    return response()->json($data, 200);
});

$router->post('/auth', 'AuthController@store');

$router->get('/rendezvous','RendezVousController@index');
$router->post('rendezvous/{id:[0-9]+}','RendezVousController@add');
$router->put('rendezvous/{id:[0-9]+}','RendezVousController@update');
$router->delete('rendezvous/{id:[0-9]+}', 'RendezVousController@deleteById');
$router->get('/rendezvous/{id:[0-9]+}','RendezVousController@getRendezVousByeleve');
$router->get('/rendezVousProf/{id:[0-9]+}','RendezVousController@getRendezVousByProf');
$router->get('rendezvous/prof_eleve/','RendezVousController@getRendezVousByProfElevejson');



$router->get('/disponibilites','DisponibilitesController@index');
$router->post('dispo/{id:[0-9]+}','DisponibilitesController@add');
$router->post('dispo/jour/{id:[0-9]+}','DisponibilitesController@disponibilite_datesjson');
$router->put('dispo/{id:[0-9]+}','DisponibilitesController@update');
$router->delete('dispo/{id:[0-9]+}', 'DisponibilitesController@deleteById');
$router->get('rendezvous/prof_eleve/','RendezVousController@getRendezVousByProfElevejson');
$router->get('/dispo/{id:[0-9]+}','DisponibilitesController@getdisponibiliteProfsur_semainejson');
$router->get('dispo/gris/','DisponibilitesController@disponibilite_sur_semainejson');
$router->get('dispo/dates/{idProf:[0-9]+}','DisponibilitesController@getDis');
$router->get('disponibilite_possible/','DisponibilitesController@getdisponibilitepossible');



$router->get('/eleveslist','ElevesController@index');
$router->post('eleve/','ElevesController@add');
$router->put('eleve/{id:[0-9]+}','ElevesController@update');
$router->delete('eleve/{id:[0-9]+}', 'ElevesController@deleteeleveById');


$router->get('/profslist','ProfesseursController@index');
$router->post('profs/','ProfesseursController@add');
$router->put('profs/{id:[0-9]+}','ProfesseursController@update');
$router->delete('profs/{id:[0-9]+}', 'ProfesseursController@deleteprofById');

$router->group(['middleware' => 'auth:api'], function ($router) {
    $router->get('/users', 'UserController@index');
});
$router->group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
    $router->get('/', 'AuthController@show');
    $router->put('/', 'AuthController@update');
    $router->delete('/', 'AuthController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'users'], function ($router) {
    $router->get('/', 'UserController@index');
    $router->post('/', 'UserController@store');
    $router->get('/{id:[0-9]+}', 'UserController@show');
    $router->put('/{id:[0-9]+}', 'UserController@update');
    $router->patch('/{id:[0-9]+}', 'UserController@update');
    $router->delete('/{id:[0-9]+}', 'UserController@destroy');
});
