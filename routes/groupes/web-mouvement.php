<?php

Route::controller(App\Http\Controllers\MouvementController::class)->group(
    function () {
        Route::prefix('mouvement')->group(
            function () {
                Route::middleware(['can:access,App\Models\Mouvement'])->group(
                    function () {
                        Route::get('/index', 'index')->name('mouvements');
                        Route::get('/grid', 'grid')->name('mouvement.grid');
                        Route::get('/create/{dir}/{article}/{zone}', 'create')->name('mouvement.create');
                        Route::post('/store/{dir}/{article}/{zone}', 'store')->name('mouvement.store');
                    }
                );
            }
        );
    }
);
