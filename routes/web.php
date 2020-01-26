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

        Route::get('/admin/brands/add', 'BrandController@addBrand')->name('add-brand');
        Route::post('/admin/brands/add', 'BrandController@postBrand')->name('add-brand');
        Route::get('/admin/brands/manage', 'BrandController@manageBrand')->name('manage-brands');
        Route::get('/admin/brands/delete/{id}', 'BrandController@deleteBrand')->name('delete-brand');
        Route::get('/admin/brands/edit/{id}', 'BrandController@editBrand')->name('edit-brand');
        Route::post('/admin/brands/edit/', 'BrandController@editedBrand')->name('edited-brand');

        Route::get('/admin/products/unit/add', 'UnitController@addUnit')->name('add-unit');
        Route::post('/admin/products/unit/add', 'UnitController@postUnit')->name('add-unit');
        Route::get('/admin/products/unit/manage', 'UnitController@manageUnit')->name('manage-units');


        Route::get('/admin/suppliers/add', 'SupplierController@create')->name('add-supplier');
        Route::post('/admin/suppliers/add', 'SupplierController@store')->name('add-supplier');
        Route::get('/admin/suppliers/manage', 'SupplierController@index')->name('manage-suppliers');
        Route::get('/admin/suppliers/edit/{id}', 'SupplierController@edit')->name('edit-supplier');
        Route::post('/admin/suppliers/edit/', 'SupplierController@update')->name('update-supplier');

    });

    Route::group(['middleware' => ['executive']], function() {
        Route::get('/admin/products/add', 'ProductController@add')->name('add-product');
        Route::post('/admin/products/add', 'ProductController@submitProduct')->name('add-product');
        Route::get('/admin/products/manage-products', 'ProductController@manage_products')->name('manage-products');
        Route::get('/admin/products/manage-products/product/add-photos/{id}', 'ProductController@add_photos')->name('add-product-photos');
        Route::post('/admin/products/manage-products/product/submit-photos', 'ProductController@submitPhotos')->name('submitPhotos');
        Route::get('/admin/products/manage-products/product/view-photos/{id}', 'ProductController@viewPhotos')->name('viewPhotos');

        Route::get('/admin/purchases/new', 'PurchaseController@create')->name('buy-products');
        Route::post('/admin/purchases/add', 'PurchaseController@store')->name('purchase-products');
        Route::get('/admin/purchases/manage', 'PurchaseController@index')->name('see-all-purchases');
        Route::post('/admin/purchases/search', 'PurchaseController@search')->name('ajax-search-products');
        Route::get('/admin/purchases/getSingleAjax/{id}', 'PurchaseController@getSingleAjax')->name('ajax-get-single');

        Route::get('/admin/customers/add', 'CustomerController@create')->name('add-customer');
        Route::post('/admin/customers/add', 'CustomerController@store')->name('add-customer');
        Route::get('/admin/customers/manage', 'CustomerController@index')->name('manage-customers');

    });
    Route::group(['middleware' => ['manager']], function() {
        Route::get('/admin/products/manage-products/product/photo/delete/{id}', 'ProductController@deleteProductPhoto')->name('deleteProductPhoto');
        Route::get('/admin/products/manage-products/product/delete/{id}', 'ProductController@deleteProduct')->name('deleteProduct');
        Route::get('/admin/products/manage-products/product/changePrice/{id}', 'ProductController@changeProductPrice')->name('changeProductPrice');
        Route::post('/admin/products/manage-products/product/update-price', 'ProductController@updateProductPrice')->name('updateProductPrice');
    });

    Route::group(['middleware' => ['seller']], function() {
        Route::get('/admin/products/sale', 'TransactionController@sell')->name('sell-products');


    });

});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('homepage');
