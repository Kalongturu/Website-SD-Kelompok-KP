<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('general/landing_page');
});
