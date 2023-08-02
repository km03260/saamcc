<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    include_once(base_path('/routes/groupes/Index.php'));
});


Route::controller(App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::get('/ssoerver/attach/user', 'authUser');
    Route::get('/ssoerver/outSession', 'outAuth');
});

Auth::routes(['register' => false, 'reset' => false]);
