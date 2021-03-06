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

Route::get('/absence-types', 'UserAbsenceController@getAbsenceTypes');

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

    Route::post('/absence-create', 'UserAbsenceController@createAbsenceRequest');
    Route::post('/overtime-create', 'UserOvertimeController@createOvertimeRequest');
    Route::get('/projects', 'UserOvertimeController@getProjects');
    Route::get('/profile', 'UserController@getProfile');
    Route::post('/profile-update', 'UserController@updateProfile');
    Route::get('/pay-slips', 'SalaryController@getPaySlips');
    Route::get('/pay-slip/{id}', 'SalaryController@getPaySlipDetail');
    Route::get('/my-projects', 'ProjectController@getUserProjects');
    Route::get('/my-projects/{id}/manager', 'ProjectController@getProjectManager');
    Route::get('/my-projects/{id}/members', 'ProjectController@getOtherMembers');
    Route::get('/notifications/latest', 'NotificationController@getLatestNotifications');
    Route::get('/notifications/all', 'NotificationController@getAllNotifications');
    Route::get('/notifications/{id}', 'NotificationController@getNotificationDetail');
    Route::post('/notifications/delete/{id}', 'NotificationController@deleteNotification');
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
    Route::get('/absence-requests/{id}', 'UserAbsenceController@getUserAbsenceDetail');
    Route::post('absence-requests/approve', 'UserAbsenceController@approveRequest');
    Route::post('absence-requests/reject', 'UserAbsenceController@rejectRequest');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/overtime-requests', 'UserOvertimeController@getUserOvertimeRequests');
    Route::get('/overtime-requests/{id}', 'UserOvertimeController@getUserOvertimeDetail');
    Route::post('overtime-requests/approve', 'UserOvertimeController@approveRequest');
    Route::post('overtime-requests/reject', 'UserOvertimeController@rejectRequest');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/employee', 'SalaryController@getEmployee');
    Route::get('/approve-absence', 'SalaryController@getUserAbsenceApprovedRequest');
    Route::get('/approve-overtime', 'SalaryController@getUserOvertimeApprovedRequest');
    Route::post('/pay-slip', 'SalaryController@submitPaySlip');
});

Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/projects', 'ProjectController@getProjects');
    Route::get('project/{id}', 'ProjectController@getProject');
    Route::post('/project/create', 'ProjectController@createProject');
    Route::post('project/update/{id}', 'ProjectController@updateProject');
    Route::post('project/delete/{id}', 'ProjectController@deleteProject');
    Route::get('project/{id}/members', 'ProjectController@getProjectMembers');
    Route::get('/positions', 'ProjectController@getPositions');
    Route::get('project/member/{id}', 'ProjectController@getMember');
    Route::post('/project/member/create', 'ProjectController@addMember');
    Route::post('project/member/update/{id}', 'ProjectController@updateMember');
    Route::post('project/member/delete/{id}', 'ProjectController@deleteMember');
});

Route::group(['middleware' => ['auth:api', 'isAdminOrSelf'], 'prefix' => 'user'], function () {
    Route::get('/info', function () {
        return "hihi";
    });
});
