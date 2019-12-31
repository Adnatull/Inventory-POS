<?php



Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/categories/add', 'CategoryController@add_category')->name('add_category');
Route::post('/admin/categories/add', 'CategoryController@post_category')->name('add_category');
Route::get('/admin/categories/manage', 'CategoryController@manage_category')->name('manage_category');

Route::get('/home', 'HomeController@index')->name('home');
