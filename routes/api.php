<?php
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::get('send', 'NotificationController@sendNotification');

Route::post('/image/store', 'ImageController@store');
Route::get('/translate', 'TranslatorController@translate');

Route::group(['middleware' => 'auth:api', 'prefix' => '/'], function () {

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/get-schedule', 'NotificationController@getSchedule');
        Route::post('test', 'NotificationController@sendTestNotification');
        Route::get('/get-token', 'NotificationController@getToken');
        Route::post('/save-token', 'NotificationController@saveToken');
        Route::post('/save-schedule', 'NotificationController@saveSchedule');

    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/id-by-slug/{slug}', 'CategoryController@getIdBySlug');
        Route::get('/total-word', 'CategoryController@getTotalWordByCategories');
    });
    Route::resource('category', 'CategoryController');

    Route::resource('/word', 'WordController');
    Route::group(['prefix' => 'word'], function () {
        Route::get('/change-important/{wordId}', 'WordController@changeImportant');
        Route::post('/update-image/{wordId}', 'WordController@updateImage');
        Route::group(['prefix' => 'priority'], function () {
            Route::post('increase', 'WordController@increasePriority');
            Route::post('decrease', 'WordController@decreasePriority');

        });
    });

    Route::get('/word-by-category/{id}', 'CategoryController@getAllWordsByCategory');

    Route::group(['prefix' => 'game'], function () {
        Route::post('game3', 'GameController@getGame3Resource');
        Route::post('game2', 'GameController@getGame2Resource');
        Route::post('game1', 'GameController@getGame1Resource');
    });

    Route::get('random-word', 'WordController@getRandomWord');
    Route::get('phrases', 'WordController@getAllPhrases');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/students', 'StudentController@getStudents');
    Route::get('student/{student}', 'StudentController@getOneStudent');
    Route::post('student', 'StudentController@storeStudent');
    Route::put('student/{student}', 'StudentController@updateStudent');
    Route::delete('student/{student}', 'StudentController@deleteOneStudent');
    Route::delete('many-students', 'StudentController@deleteManyStudent');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/absence-requests', 'UserAbsenceController@getUserAbsenceRequests');
    Route::post('absence-requests/approve', 'UserAbsenceController@approveRequest');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/overtime-requests', 'UserOvertimeController@getUserOvertimeRequests');
});

Route::group(['middleware' => ['auth:api', 'isAdminOrSelf'], 'prefix' => 'user'], function () {
    Route::get('/info', function () {
        return "hihi";
    });
});
