<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'],function (){

    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/balance', 'BalanceController@index')->name('balance.index');
    Route::get('/deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::post('deposit/store', 'BalanceController@depositStore')->name('deposit.store');

    Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

    Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    Route::post('transfer-confirm', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');

    Route::get('historics', 'BalanceController@historics')->name('balance.historics');

    Route::any('historic-search', 'BalanceController@search')->name('historic.search');

});

Route::get('meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');
Route::post('atualizar-perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');


Route::get('/', 'Site\SiteController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
