<?php



Auth::routes();


Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/admin/no-permission', 'AdminController@permissionDenied')->name('noPermission');


    Route::group(['middleware' => ['admin']], function() {
        Route::get('/admin/categories/add', 'CategoryController@add_category')->name('add_category');
        Route::post('/admin/categories/add', 'CategoryController@post_category')->name('add_category');
        Route::get('/admin/categories/manage', 'CategoryController@manage_category')->name('manage_category');
        Route::get('/admin/categories/delete/{id}', 'CategoryController@deleteCategory')->name('deleteCategory');
        Route::get('/admin/categories/edit/{id}', 'CategoryController@editCategory')->name('editCategory');
        Route::post('/admin/categories/edit/', 'CategoryController@editedCategory')->name('editedCategory');

        Route::get('/admin/manage-users', 'AdminController@manage_users')->name('manage-users');
        Route::post('/admin/manage-users/remove-role', 'AdminController@remove_role')->name('remove-role');
        Route::post('/admin/manage-users/give-role', 'AdminController@give_role')->name('give-role');
    });

    Route::group(['middleware' => ['executive']], function() {
        Route::get('/admin/products/add', 'ProductController@add')->name('add-product');
        Route::post('/admin/products/add', 'ProductController@submitProduct')->name('add-product');
        Route::get('/admin/products/manage-products', 'ProductController@manage_products')->name('manage-products');
        Route::get('/admin/products/manage-products/add-photos/{id}', 'ProductController@add_photos')->name('add-product-photos');
        Route::post('/admin/products/manage-products/submit-photos', 'ProductController@submitPhotos')->name('submitPhotos');
    });


});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('homepage');
