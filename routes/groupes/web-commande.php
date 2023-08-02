<?php

Route::prefix('commande')->group(
    function () {
        Route::middleware(['can:access,App\Models\Commande'])->group(
            function () {
                Route::controller(App\Http\Controllers\CommandeController::class)->group(
                    function () {
                        Route::get('/index', 'index')->name('commandes');
                        Route::get('/grid', 'grid')->name('commande.grid');
                        Route::get('/create', 'create')->name('commande.create');
                        Route::post('/store', 'store')->name('commande.store');
                        Route::get('/show/{commande}', 'show')->name('commande.show');
                        Route::post('/update/{commande}', 'update')->name('commande.update');
                        Route::post('/savewhat/{commande}', 'savewhat')->name('commande.savewhat');
                        Route::get('/destroy/{commande}', 'destroy')->name('commande.destroy');
                        Route::get('/fields/{client}', 'fields')->name('commande.fields');
                    }
                );
                Route::prefix('ligne')->group(
                    function () {
                        Route::controller(App\Http\Controllers\LcommandeController::class)->group(
                            function () {
                                Route::get('/row', 'row')->name('commande.ligne.row');
                                Route::get('/grid', 'grid')->name('commande.ligne.grid');
                                Route::get('/destroy/{lcommande}', 'destroy')->name('lcommande.destroy');
                                Route::get('/create/{commande}', 'create')->name('commande.ligne.create');
                                Route::post('/store', 'store')->name('commande.ligne.store');
                            }
                        );
                    }
                );
            }
        );
    }
);
