<?php
Route::get('/', function () {
    return view('welcome');
});

// Annotator Route
Route::prefix('annotator')->name('annotator.')->group(function(){

    Route::middleware('guest')->group(function(){
        Route::get('login', 'AnnotatorLoginController@login')->name('login');
        Route::post('login', 'AnnotatorLoginController@loginPost')->name('login');
    });

    Route::middleware('auth:annotator')->group(function(){
        Route::get('logout', 'AnnotatorLoginController@logout')->name('logout');
        Route::get('/', 'AdminController@index')->name('home');

        // Task Route
        Route::prefix('task')->name('task.')->group(function(){
            Route::get('/', 'TaskController@notBooked')->name('not.booked');
            Route::get('not-booked-datatables', 'TaskController@notBookedDatatables')->name('not.booked.datatables');
            Route::get('download/{id}', 'TaskController@download')->name('download');
            Route::get('book/{id}', 'TaskController@book')->name('book');
            Route::get('my-tasks', 'AnnotatorController@myTasks')->name('my.tasks');
            Route::get('my-tasks-datatables', 'AnnotatorController@myTasksDatatables')->name('my.tasks.datatables');
        });
    });
});


// Admin Route
Route::prefix('admin')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('login', 'AdminController@login')->name('admin.login');
        Route::post('login', 'AdminController@loginPost')->name('admin.login');
    });

    Route::middleware('auth')->group(function(){
        Route::get('/', 'AdminController@index')->name('admin.home');
        Route::get('logout', 'AdminController@logout')->name('admin.logout');

        // Routing Annotator
        Route::get('annotator-all-datatables', 'AnnotatorController@allDatatables')->name('annotator.all.datatables');
        Route::resource('annotator', 'AnnotatorController'); // Here contain CRUD Annotator routes

        // Routing Task
        Route::prefix('task')->group(function(){
            Route::get('all-datatables', 'TaskController@allDatatables')->name('task.all.datatables');
            Route::get('not-booked-datatables', 'TaskController@notBookedDatatables')->name('task.not.booked.datatables');
            Route::get('download/{id}', 'TaskController@download')->name('task.download');
            Route::put('revoke/{id}', 'TaskController@revoke')->name('task.revoke');
        });
        Route::resource('task', 'TaskController'); // Here contain CRUD Task routes
    });
});

