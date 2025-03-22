<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::post('api/login', 'AuthController@login');

Route::group([

    'prefix' => 'api',

], function ($router) {
    
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@me');


    Route::get('branches', 'BranchController@getAllBranches');
    Route::get('branches/{id}', 'BranchController@getBranch');
    Route::post('branches', 'BranchController@addBranch');
    Route::put('branches/{id}', 'BranchController@updateBranch');
    Route::delete('branches/{id}', 'BranchController@deleteBranch');
    Route::get('formdata', 'BranchController@getAllFormData');

    Route::get('clients', 'ClientController@getAllClients');
    Route::get('clients/{id}', 'ClientController@getClient');
    Route::post('clients', 'ClientController@addClient');
    Route::put('clients/{id}', 'ClientController@updateClient');
    Route::delete('clients/{id}', 'ClientController@deleteClient');
    Route::get('clients-list', 'ClientController@getAllClientsList');

    Route::get('events', 'EventController@getAllEvents');
    Route::get('events/{id}', 'EventController@getEvent');
    Route::post('events', 'EventController@addEvent');
    Route::put('events/{id}', 'EventController@updateEvent');
    Route::delete('events/{id}', 'EventController@deleteEvent');

    Route::get('jobs', 'JobController@getAllJobs');
    Route::get('posted-jobs', 'JobController@getAllJobsFront');
    Route::get('dashboard-jobs', 'JobController@getDashboardJobs');
    Route::get('dashboard-clients-jobs', 'JobController@getDashboardClientsJobs');
    Route::get('jobs/{id}', 'JobController@getJob');
    Route::post('jobs', 'JobController@addJob');
    Route::put('jobs/{id}', 'JobController@updateJob');
    Route::delete('jobs/{id}', 'JobController@deleteJob');
    

    Route::get('job-seekers', 'JobSeekerController@getAllJobseekers');
    Route::get('job-seekers/{id}', 'JobSeekerController@getJobseeker');
    Route::post('job-seekers', 'JobSeekerController@addJobseeker');
    Route::put('job-seekers/{id}', 'JobSeekerController@updateJobseeker');
    Route::delete('job-seekers/{id}', 'JobSeekerController@deleteJobseeker');
    Route::post('send-otp', 'JobSeekerController@sendOTP');
    Route::post('verify-otp', 'JobSeekerController@verifyOTP');
    Route::post('download-document', 'JobSeekerController@getDocument');
});