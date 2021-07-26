<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckHeader;





    // ========================Auth Client Api ========================
    Route::post('client-login', 'App\Http\Controllers\API\AuthController@login');
    Route::post('client-register', 'App\Http\Controllers\API\AuthController@register');
    // ========================End Auth Client Api =======================

   //=========================Add,update And Delete tasks Links===========
    Route::post('get-my-tasks', 'App\Http\Controllers\API\TaskController@getMyTasks');  //delete-task
    Route::post('add-task', 'App\Http\Controllers\API\TaskController@addTask');  //add-task
    Route::post('update-task', 'App\Http\Controllers\API\TaskController@updateTask');  //update-task
    Route::post('update-task-status', 'App\Http\Controllers\API\TaskController@updateTaskStatus');  //update-task
    Route::post('dalete-task', 'App\Http\Controllers\API\TaskController@deleteTask');  //delete-task


