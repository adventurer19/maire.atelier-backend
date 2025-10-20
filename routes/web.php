<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('admin.locale.switch')->middleware(['web', 'auth']);
