<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/php-83', function () {
    return (new Response())
        ->header('Content-Type', 'application/json')
        ->setContent(['status' => 'success'])
        ->setStatusCode(200);
});

Route::get('/php-84', function () {
    return new Response()
        ->header('Content-Type', 'application/json')
        ->setContent(['status' => 'success'])
        ->setStatusCode(200);
});
