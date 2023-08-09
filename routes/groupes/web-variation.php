<?php

Route::controller(App\Http\Controllers\VariationController::class)->group(
    function () {
        Route::prefix('variation')->group(
            function () {
                Route::middleware(['can:access,App\Models\Variation'])->group(
                    function () {
                        Route::get('/index', 'index')->name('variations');
                        Route::get('/grid', 'grid')->name('variation.grid');
                        Route::get('/create', 'create')->name('variation.create');
                        Route::post('/store', 'store')->name('variation.store');
                        Route::post('/update/{variation}', 'update')->name('variation.update');
                        Route::get('/destroy/{variation}', 'destroy')->name('variation.destroy');
                    }
                );
            }
        );
    }
);
