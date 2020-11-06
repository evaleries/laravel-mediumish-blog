<?php

use Illuminate\Support\Facades\Route;

Route::get('/{id}-{slug}', 'PostController@show')->name('post.show');
Route::get('/', HomeController::class)->name('home');
Route::resource('post', PostController::class)->except('show');
