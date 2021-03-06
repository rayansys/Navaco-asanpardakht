<?php

Route::get('install', 'InstallController@index')->name('install');
Route::post('install', 'InstallController@install');
Route::get('install/complete', 'InstallController@showComplete')->name('install-complete');
Route::post('install/complete', 'InstallController@complete');

Route::group(['middleware' => 'check-installation'], function ()
{
    Route::get('login', 'Auth\AuthController@getLogin')->name('login');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout')->name('logout');

    Route::get('/', 'FormController@index')->name('home-index');
    Route::get('form/{id?}', 'FormController@index')->name('form');
    Route::post('form/{id?}', 'FormController@pay');

    Route::get('factor/{id}', 'FactorController@index')->name('factor');
    Route::post('factor/{id}', 'FactorController@pay');

    Route::any('callback/index.php', 'PaymentController@pay')->name('callback');

	Route::any('pg/callback/', 'PaymentController@callbackPayment')->name('pg-callback');

    Route::get('pg/pay/{id}', 'PaymentController@pay')->name('pg-pay');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        Route::get('/', 'Admin\DashboardController@index')->name('admin-dashboard');
        Route::get('live', 'Admin\DashboardController@live')->name('admin-dashboard-live');
        Route::get('live/toggle', 'Admin\DashboardController@toggleLive')->name('admin-dashboard-live-toggle');

        Route::get('transactions', 'Admin\TransactionController@index')->name('admin-transactions');
        Route::get('transactions/filter', 'Admin\TransactionController@filter')->name('admin-transactions-filter');
        Route::get('transactions/detail/{id}', 'Admin\TransactionController@detail')->name('admin-transactions-detail');

        Route::get('forms', 'Admin\FormController@index')->name('admin-forms');
        Route::get('forms/add', 'Admin\FormController@showAdd')->name('admin-forms-add');
        Route::post('forms/add', 'Admin\FormController@add');
        Route::get('forms/edit/{id}', 'Admin\FormController@showEdit')->name('admin-forms-edit');
        Route::post('forms/edit/{id}', 'Admin\FormController@edit');
        Route::get('forms/delete/{id}', 'Admin\FormController@delete')->name('admin-forms-delete');
        Route::get('forms/default/{id}', 'Admin\FormController@makeDefault')->name('admin-forms-default');

        Route::get('factors', 'Admin\FactorController@index')->name('admin-factors');
        Route::get('factors/filter', 'Admin\FactorController@filter')->name('admin-factors-filter');
        Route::get('factors/add', 'Admin\FactorController@showAdd')->name('admin-factors-add');
        Route::post('factors/add', 'Admin\FactorController@add');
        Route::get('factors/edit/{id}', 'Admin\FactorController@showEdit')->name('admin-factors-edit');
        Route::post('factors/edit/{id}', 'Admin\FactorController@edit');
        Route::get('factors/delete/{id}', 'Admin\FactorController@delete')->name('admin-factors-delete');

        Route::get('configs', 'Admin\ConfigController@index')->name('admin-configs');
        Route::post('configs', 'Admin\ConfigController@edit');

        Route::get('security-settings', 'Admin\SecuritySettingController@index')->name('admin-security-settings');
        Route::post('security-settings/change-password', 'Admin\SecuritySettingController@changePassword')->name('admin-security-settings-change-password');

        Route::get('update', 'Admin\UpdateController@index')->name('admin-update');
        Route::get('update/install', 'Admin\UpdateController@install')->name('admin-update-install');
        Route::get('update/finish', 'Admin\UpdateController@finish')->name('admin-update-finish');
    });
});
