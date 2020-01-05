<?php



Auth::routes();


Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::group(['middleware' => ['admin']], function() {
        Route::get('/admin/categories/add', 'CategoryController@add_category')->name('add_category');
        Route::post('/admin/categories/add', 'CategoryController@post_category')->name('add_category');
        Route::get('/admin/categories/manage', 'CategoryController@manage_category')->name('manage_category');
        Route::get('/admin/categories/delete/{id}', 'CategoryController@deleteCategory')->name('deleteCategory');
        Route::get('/admin/categories/edit/{id}', 'CategoryController@editCategory')->name('editCategory');
        Route::post('/admin/categories/edit/', 'CategoryController@editedCategory')->name('editedCategory');
    });

    Route::get('/admin/no-permission', 'AdminController@permissionDenied')->name('noPermission');


});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('homepage');
