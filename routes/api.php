<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('todo', 'TodoController');

Route::put('/todo/{todo}/toggle-complete', 'TodoController@setTaskCompletion');

Route::get('/todo/sort/{value}', 'TodoController@sortTasks');
