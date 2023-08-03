<?php


Route::controller(App\Http\Controllers\ClientController::class)->group(
    function () {

        Route::middleware(['operator', 'can:access,App\Models\Client'])->group(
            function () {
                Route::get('/', 'index')->name('clients');
            }
        );
        Route::prefix('client')->group(
            function () {
                Route::get('/grid', 'grid')->name('client.grid');
                Route::middleware(['can:access,App\Models\Client'])->group(
                    function () {
                        Route::get('/create', 'create')->name('client.create');
                        Route::post('/store', 'store')->name('client.store');
                        Route::get('/show/{client}', 'show')->name('client.show');
                        Route::post('/update/{client}', 'update')->name('client.savewhat');
                        Route::get('/destroy/{client}', 'destroy')->name('client.destroy');
                    }
                );
            }
        );
    }
);
