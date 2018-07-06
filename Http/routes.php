<?php

Route::group(['middleware' => 'web', 'prefix' => 'kiroku', 'namespace' => 'Modules\Kiroku\Http\Controllers'], function () {
    Route::get('/', 'KirokuController@index');
});
Route::get('demo/config', function () {
    return config('websanova-demo-main.hello') .
    config('websanova-demo-main.world');
});
