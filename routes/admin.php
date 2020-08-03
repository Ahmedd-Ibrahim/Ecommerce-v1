<?php

use Illuminate\Support\Facades\Route;


########################## admin Route ###################################


define('PAGINATION_COUNT',10);

// Begin Guest Routes
Route::group(['prefix'=> 'admin','namespace'=>'back', 'middleware'=>'guest:admin'],function (){
    Route::get('login','loginController@getLogin')->name('admin.form');
    Route::post('login','loginController@login')->name('admin.login');

});
// End Guest Routes

// Begin Auth Admin Routes
Route::group(['prefix'=> 'admin','namespace'=>'back', 'middleware' => 'auth:admin'],function (){

    Route::get('/','loginController@index')->name('admin.index');
    Route::post('logout','loginController@logout')->name('admin.logout');


    ######################### Begin Languages ################################
    Route::group(['prefix'=>'languages'],function(){
        Route::get('/','languagesController@index')->name('admin.languages');
        Route::get('/create','languagesController@create')->name('admin.languages.create');
        Route::post('/store','languagesController@store')->name('admin.languages.store');
        Route::get('/edit/{id}','languagesController@edit')->name('admin.languages.edit');
        Route::post('/edit/{id}','languagesController@update')->name('admin.languages.update');
        Route::get('/destroy/{id}','languagesController@destroy')->name('admin.languages.destroy');
    });
    ########################### Begin Languages ################################
    #

    #  ######################### Begin main Categories ################################
    Route::group(['prefix'=>'categories'],function(){
        Route::get('/','mainCategoryController@index')->name('admin.categories');
        Route::get('/create','mainCategoryController@create')->name('admin.categories.create');
        Route::post('/store','mainCategoryController@store')->name('admin.categories.store');
        Route::get('/edit/{id}','mainCategoryController@edit')->name('admin.categories.edit');
        Route::post('/update/{id}','mainCategoryController@update')->name('admin.categories.update');
        Route::get('/destroy/{id}','mainCategoryController@destroy')->name('admin.categories.destroy');
        Route::get('/activation/{id}','mainCategoryController@activation')->name('admin.categories.activation');
    });
    ########################### End Main Categories ####################################


    ########################## Begin sub Categories ################################
    Route::group(['prefix'=>'categories/sub'],function(){
        Route::get('/','subCategoryController@index')->name('admin.subCategories');
        Route::get('/create','subCategoryController@create')->name('admin.subCategories.create');
        Route::post('/store','subCategoryController@store')->name('admin.subCategories.store');
        Route::get('/edit/{id}','subCategoryController@edit')->name('admin.subCategories.edit');
        Route::post('/update/{id}','subCategoryController@update')->name('admin.subCategories.update');
        Route::get('/destroy/{id}','subCategoryController@destroy')->name('admin.subCategories.destroy');
        Route::get('/activation/{id}','subCategoryController@activation')->name('admin.subCategories.activation');
    });
    ########################### End sub Categories ####################################

    ########################### Begin Vendor ################################
    Route::group(['prefix'=>'vendor'],function(){
        Route::get('/','vendorController@index')->name('admin.vendor');
        Route::get('/create','vendorController@create')->name('admin.vendor.create');
        Route::post('/store','vendorController@store')->name('admin.vendor.store');
        Route::get('/edit/{id}','vendorController@edit')->name('admin.vendor.edit');
        Route::post('/update/{id}','vendorController@update')->name('admin.vendor.update');
        Route::get('/destroy/{id}','vendorController@destroy')->name('admin.vendor.destroy');
        Route::get('/activation/{id}','vendorController@activation')->name('admin.vendor.activation');
    });
    ########################### End Vendor ################################
    ########################### Begin product ################################
    Route::group(['prefix'=>'product'],function(){
        Route::get('/','productController@index')->name('admin.product');
        Route::get('/create','productController@create')->name('admin.product.create');
        Route::post('/store','productController@store')->name('admin.product.store');
        Route::get('/edit/{id}','productController@edit')->name('admin.product.edit');
        Route::post('/update/{id}','productController@update')->name('admin.product.update');
        Route::get('/destroy/{id}','productController@destroy')->name('admin.product.destroy');
        Route::get('/activation/{id}','productController@activation')->name('admin.product.activation');
    });
  ########################### End product ################################

});
 ########################## admin Route ###################################

// End Auth Admin Routes

