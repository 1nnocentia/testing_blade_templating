<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about', ['nama' => 'Innocentia Handani']);
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/contact', function () {
    return view('contact');
});

// Route::get('/', function (Illuminate\Http\Request $request) {
//     $input = $request->query('input');
//     return view('home', ['input' => $input]);
// });
