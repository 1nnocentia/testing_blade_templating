<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function (Illuminate\Http\Request $request) {
    $input = $request->query('input');
    return view('home', ['input' => $input]);
});
