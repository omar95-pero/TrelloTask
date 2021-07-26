<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckHeader;


Route::group(['namespace' => 'API'], function () {


    // ========================Auth Client Api ========================
    Route::post('client-login', 'ClientAuthController@login');
    Route::post('client-register', 'ClientAuthController@register');
    // ========================End Auth Client Api ========================



});
