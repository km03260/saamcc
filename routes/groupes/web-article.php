<?php

Route::controller(App\Http\Controllers\ArticleController::class)->group(
    function () {
        Route::prefix('article')->group(
            function () {
                Route::middleware(['can:access,App\Models\Article'])->group(
                    function () {
                        Route::get('/index', 'index')->name('articles');
                        Route::get('/grid', 'grid')->name('article.grid');
                        Route::get('/create', 'create')->name('article.create');
                        Route::post('/store', 'store')->name('article.store');
                        Route::get('/show/{article}', 'show')->name('article.show');
                        Route::post('/update/{article}', 'update')->name('article.update');
                        Route::post('/savewhat/{article}', 'savewhat')->name('article.savewhat');
                        Route::get('/destroy/{article}', 'destroy')->name('article.destroy');
                    }
                );
            }
        );
    }
);
