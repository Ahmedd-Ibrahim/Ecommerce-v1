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
    });
    ########################### End Main Categories ####################################


    # #  ######################### Begin Vendor ################################
    Route::group(['prefix'=>'vendor'],function(){
        Route::get('/','vendorController@index')->name('admin.vendor');
        Route::get('/create','vendorController@create')->name('admin.vendor.create');
        Route::post('/store','vendorController@store')->name('admin.vendor.store');
        Route::get('/edit/{id}','vendorController@edit')->name('admin.vendor.edit');
        Route::post('/update/{id}','vendorController@update')->name('admin.vendor.update');
        Route::get('/destroy/{id}','vendorController@destroy')->name('admin.vendor.destroy');
    });
    ########################### End Vendor ################################

});
 ########################## admin Route ###################################

// End Auth Admin Routes

