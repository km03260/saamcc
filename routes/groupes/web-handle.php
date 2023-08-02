<?php

Route::prefix('handle')->group(
    function () {
        Route::controller(App\Http\Controllers\HandleController::class)->group(
            function () {
                Route::get('/select/{target}', 'search')->name('handle.select');
                Route::get('/render', 'render')->name('handle.render');
            }
        );
    }
);
