<?php



Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/categories/add', 'AdminController@add_category')->name('add_category');
Route::get('/admin/categories/manage', 'AdminController@manage_category')->name('manage_category');

Route::get('/home', 'HomeController@index')->name('home');
