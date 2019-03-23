<?php
Auth::routes();
Route::group(['namespace' => 'front'], function () {
    Route::get('/', 'indexController@index')->name('index');
    Route::get('/cevaplanmis', 'indexController@cevaplanmis')->name('cevaplanmis');
    Route::get('/cozumlenmis', 'indexController@cozumlenmis')->name('cozumlenmis');

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'question', 'as' => 'question.', 'prefix' => 'soru'], function () {
            Route::get('/olustur', 'indexController@create')->name('create');
            Route::post('/olustur', 'indexController@store')->name('store');
            Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
            Route::post('/duzenle/{id}', 'indexController@update')->name('update');
            Route::get('/sil/{id}', 'indexController@delete')->name('delete');
        });

        Route::group(['namespace' => 'comment', 'as' => 'comment.', 'prefix' => 'comment'], function () {
            Route::post('/store/{id}', 'indexController@store')->name('store');
            Route::get('/like/{id}', 'indexController@likeOrDislike')->name('likeordislike');
            Route::get('/delete/{id}', 'indexController@delete')->name('delete');
            Route::get('/correct/{id}', 'indexController@correct')->name('correct');
        });

        Route::group(['namespace' => 'settings', 'as' => 'settings.', 'prefix' => 'ayarlar'], function () {
            Route::get('/bildirimler', 'indexController@notifications')->name('notifications');
            Route::get('/', 'indexController@index')->name('index');
            Route::post('/', 'indexController@store')->name('store');
            Route::get('/sifre', 'indexController@password')->name('password');
            Route::post('/sifre', 'indexController@passwordStore')->name('passwordStore');
        });

        Route::group(['namespace' => 'user', 'as' => 'user.', 'prefix' => 'kullanici'], function () {
            Route::get('/hepsi', 'indexController@all')->name('all');
            Route::get('/{id}', 'indexController@index')->name('index');

        });

        Route::group(['namespace' => 'save', 'as' => 'save.', 'prefix' => 'kaydet'], function () {
            Route::get('/', 'indexController@index')->name('index');
            Route::get('/soru/{id}', 'indexController@store')->name('store');
        });

    });

    Route::group(['namespace' => 'search', 'as' => 'search.', 'prefix' => 'ara'], function () {
        Route::get('/', 'indexController@index')->name('index');
    });

    Route::group(['namespace' => 'category', 'as' => 'category.', 'prefix' => 'kategori'], function () {
        Route::get('/{selflink}', 'indexController@index')->name('index');
    });

    Route::group(['namespace' => 'tags', 'as' => 'tags.', 'prefix' => 'etiket'], function () {
        Route::get('/','indexController@index')->name('index');
        Route::get('/{selflink}', 'indexController@view')->name('view');
    });

    Route::get('/{selflink}/{id}', 'indexController@view')->name('view')->middleware(['VisitorUser']);
});


