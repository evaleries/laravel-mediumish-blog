<?php

use Illuminate\Support\Facades\Route;

Route::get('/{id}-{slug}', 'PostController@show')->name('post.show');
Route::get('/', 'PostController@index')->name('home');
Route::resource('post', PostController::class)->except('show');
