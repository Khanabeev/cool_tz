<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['throttle:3'])->namespace('\App\Http\Controllers\Api\V1')->group(function () {
    Route::post('/add-message', 'MessageController@store');
});
