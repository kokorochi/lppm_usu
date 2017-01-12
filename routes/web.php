<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// default public route
Route::get('/', 'HomeController@index');

// TESTING Route
Route::get('files/upload', 'TestingController@upload');
Route::post('files/upload', 'TestingController@storeUpload');
Route::get('tests', 'TestingController@index');

// End TESTING Route

// Login Route
Route::get('user/login', 'LoginController@showLoginForm');
Route::post('user/login', 'LoginController@doLogin');
Route::get('user/logout', 'LoginController@doLogout');
Route::get('user/reset', 'LoginController@reset');
Route::put('user/reset', 'LoginController@doReset');
// End Login Route

// Announces Route
Route::get('announces/', 'AnnouncesController@index');

Route::get('announces/create', 'AnnouncesController@create');
Route::post('announces/create', 'AnnouncesController@store');

Route::get('announces/{id}/edit', 'AnnouncesController@edit');
Route::put('announces/{id}/edit', 'AnnouncesController@update');

Route::delete('announces/{id}', 'AnnouncesController@destroy');

Route::get('announces/{id}', 'AnnouncesController@showSingleList');
// End Announces Route

// Appraisal Route
Route::get('appraisals/', 'AppraisalController@index');

Route::get('appraisals/create', 'AppraisalController@create');
Route::post('appraisals/create', 'AppraisalController@store');

Route::get('appraisals/{id}/edit', 'AppraisalController@edit');
Route::put('appraisals/{id}/edit', 'AppraisalController@update');

Route::delete('appraisals/{id}', 'AppraisalController@destroy');
//End Appraisal Route

// Category Types Route
Route::get('category-types/', 'CategoryTypeController@index');

Route::get('category-types/create', 'CategoryTypeController@create');
Route::post('category-types/create', 'CategoryTypeController@store');

Route::get('category-types/{id}/edit', 'CategoryTypeController@edit');
Route::put('category-types/{id}/edit', 'CategoryTypeController@update');

Route::delete('category-types/{id}', 'CategoryTypeController@destroy');
// End Category Types Route

// Dedication Types Route
Route::get('dedication-types/', 'DedicationTypeController@index');

Route::get('dedication-types/create', 'DedicationTypeController@create');
Route::post('dedication-types/create', 'DedicationTypeController@store');

Route::get('dedication-types/{id}/edit', 'DedicationTypeController@edit');
Route::put('dedication-types/{id}/edit', 'DedicationTypeController@update');

Route::delete('dedication-types/{id}', 'DedicationTypeController@destroy');
// End Dedication Types Route

// Periods Route
Route::get('periods/', 'PeriodController@index');

Route::get('periods/create', 'PeriodController@create');
Route::post('periods/create', 'PeriodController@store');

Route::get('periods/{id}/edit', 'PeriodController@edit');
Route::put('periods/{id}/edit', 'PeriodController@update');

Route::delete('periods/{id}', 'PeriodController@destroy');
// End Periods Route

// Proposes Route
Route::get('proposes/', 'ProposeController@index');

Route::get('proposes/create', 'ProposeController@create');
Route::post('proposes/create', 'ProposeController@store');

Route::get('proposes/{id}/edit', 'ProposeController@edit');
Route::put('proposes/{id}/edit', 'ProposeController@update');

Route::get('proposes/{id}/revision', 'ProposeController@revision');
Route::put('proposes/{id}/revision', 'ProposeController@revisionUpdate');

Route::get('proposes/{id}/download/{type}', 'ProposeController@getFile');

Route::get('proposes/{id}/verification', 'ProposeController@verification');
Route::put('proposes/{id}/verification', 'ProposeController@updateVerification');

Route::get('proposes/{id}/print-confirmation', 'ProposeController@printConfirmation');

Route::delete('proposes/{id}', 'ProposeController@destroy');
// End Proposes Route

// Begin Reviewer Route
Route::get('reviewers/', 'ReviewerController@index');

Route::get('reviewers/create', 'ReviewerController@create');
Route::post('reviewers/create', 'ReviewerController@store');

Route::get('reviewers/{id}/edit', 'ReviewerController@edit');
Route::put('reviewers/{id}/edit', 'ReviewerController@update');

Route::get('reviewers/assign', 'ReviewerController@assignList');
Route::get('reviewers/assign/{id}', 'ReviewerController@assign');
Route::post('reviewers/assign/{id}', 'ReviewerController@assignUpdate');
// End Reviewer Route

// Start Review Proposes Route
Route::get('review-proposes/', 'ReviewProposeController@index');
Route::get('review-proposes/{id}/review', 'ReviewProposeController@review');
Route::post('review-proposes/{id}/review', 'ReviewProposeController@reviewUpdate');
Route::get('review-proposes/{id}/print-review', 'ReviewProposeController@printReview');
Route::get('review-proposes/dedication-list', 'ReviewProposeController@dedicationList');
Route::get('review-proposes/{id}/dedication-display', 'ReviewProposeController@dedicationDisplay');
// End Review Proposes Route

// Start Approve Proposes Route
Route::get('approve-proposes/', 'ApproveProposeController@index');
Route::get('approve-proposes/{id}/approve', 'ApproveProposeController@approve');
Route::put('approve-proposes/{id}/approve', 'ApproveProposeController@approveUpdate');
// End Approve Proposes Route

// Start Dedication Route
Route::get('dedications/', 'DedicationController@index');
Route::get('dedications/{id}/edit', 'DedicationController@edit');
Route::put('dedications/{id}/edit-progress', 'DedicationController@updateProgress');
Route::put('dedications/{id}/edit-final', 'DedicationController@updateFinal');
Route::get('dedications/{id}/download/{type}', 'DedicationController@getFile');
Route::get('dedications/{id}/output', 'DedicationController@output');
Route::get('dedications/{id}/output-download/{type}', 'DedicationController@getOutputFile');
Route::get('dedications/{id}/output-download/{type}/{subtype}', 'DedicationController@getOutputFile');
Route::put('dedications/{id}/output-service', 'DedicationController@updateOutputService');
Route::put('dedications/{id}/output-method', 'DedicationController@updateOutputMethod');
Route::put('dedications/{id}/output-product', 'DedicationController@updateOutputProduct');
Route::put('dedications/{id}/output-patent', 'DedicationController@updateOutputPatent');
Route::put('dedications/{id}/output-guidebook', 'DedicationController@updateOutputGuidebook');
Route::get('dedications/approve-list', 'DedicationController@approveList');
Route::get('dedications/{id}/approve', 'DedicationController@approveDetail');
Route::put('dedications/{id}/approve', 'DedicationController@approveUpdate');
// End Dedication Route

// AJAX Route
Route::get('ajax/periods/get', 'AJAXController@getPeriod');
Route::get('ajax/members/search', 'AJAXController@searchLecturer');
Route::get('ajax/members/lecturerNIDN', 'AJAXController@getLecturerByNIDN');
Route::get('ajax/proposes/getbyscheme', 'AJAXController@getProposesByScheme');
Route::get('ajax/reviewers/get', 'AJAXController@getReviewer');
Route::get('ajax/reviewers/search', 'AJAXController@searchReviewer');
Route::get('ajax/dedications/get', 'AJAXController@getDedication');
// End AJAX Route