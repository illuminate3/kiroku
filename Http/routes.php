<?php

Route::group(['middleware' => 'web', 'prefix' => 'kiroku', 'namespace' => 'Modules\Kiroku\Http\Controllers'], function () {
    Route::get('/', 'KirokuController@index');
});
