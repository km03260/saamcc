<?php

use Illuminate\Support\Facades\Gate;

Route::controller(App\Http\Controllers\StockController::class)->group(
    function () {
        Route::prefix('stock')->group(
            function () {
                Route::middleware(['can:access,App\Models\Stock'])->group(
                    function () {
                        Route::get('/index', 'index')->name('stocks');
                        Route::get('/grid', 'grid')->name('stock.grid');
                        Route::get('/create', 'create')->name('stock.create');
                        Route::post('/store', 'store')->name('stock.store');
                        Route::get('/show/{article}', 'show')->name('stock.show');
                        Route::post('/update/{stock}', 'update')->name('stock.update');
                        Route::post('/savewhat/{stock}', 'savewhat')->name('stock.savewhat');
                        Route::get('/destroy/{stock}', 'destroy')->name('stock.destroy');
                        Route::post('/sens/{dir}/{article}/{zone}', 'sens')->name('stock.sens');
                    }
                );
            }
        );
    }
);
