<?php

Route::controller(App\Http\Controllers\UserController::class)->group(
    function () {
        Route::prefix('user')->group(
            function () {
                Route::middleware(['can:access,App\Models\User'])->group(
                    function () {
                        Route::get('/index', 'index')->name('users');
                        Route::get('/grid', 'grid')->name('user.grid');
                        Route::get('/create', 'create')->name('user.create');
                        Route::get('/reset-password/{user}', 'reset')->name('user.resetPassword');
                        Route::post('/new-password/{user}', 'resetPassword')->name('user.newPassword');
                        Route::post('/store', 'store')->name('user.store');
                        Route::get('/show/{user}', 'show')->name('user.show');
                        Route::post('/update/{user}', 'update')->name('user.update');
                        Route::post('/savewhat/{user}', 'savewhat')->name('user.savewhat');
                        Route::get('/destroy/{user}', 'destroy')->name('user.destroy');
                    }
                );
            }
        );
    }
);
