<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function (){
    return redirect()->route('home');
});


Route::get('/profile/{id}','UserController@show');

// Authentication Routes...
Auth::routes();

// Registration Routes...
Route::post('validate_funder', 'Auth\RegisterController@validateFunder');
Route::post('validate_student', 'Auth\RegisterController@validateStudent');
Route::post('validate_user', 'Auth\RegisterController@validateUser')->name('user.validate');
Route::post('register_final', 'Auth\RegisterController@registerFinal');

Route::get('school_types', 'Auth\RegisterController@getSchoolTypes');
Route::get('schools', 'Auth\RegisterController@getSchoolsBySchoolTypeID');
Route::get('enrollments', 'Auth\RegisterController@getEnrollmentsBySchoolTypeID');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

/**
 * Info pages, about, contact etc..
 */
Route::group(['prefix' => 'info_pages'], function (){
    Route::get('about', 'InfoPagesController@about')->name('info_pages.about');
    Route::get('faq', 'InfoPagesController@faq')->name('info_pages.faq');
    Route::get('tac', 'InfoPagesController@tac')->name('info_pages.tac');
});

/**
 * CPanel for admin
 */
Route::group(['prefix' => 'c_panel', 'namespace' => 'CPanel', 'middleware' => ['auth', 'admin']], function (){
    Route::get('users/bank_accounts', 'CPanelController@usersBankAccounts')->name('c_panel.users.bank_accounts');
    Route::put('users/bank_accounts/{user_id}/change_status', 'CPanelController@usersBankAccountsChangeStatus')->name('c_panel.users.bank_accounts.change_status');
    Route::get('payouts', 'CPanelController@payouts')->name('c_panel.payouts');
    Route::put('payouts/{payout_id}/change_status', 'CPanelController@payoutsChangeStatus')->name('c_panel.payouts.change_status');
});


/**
 * Verify routes
 */
Route::get('verify/academic_year', 'Verify\AcademicYearController@verifyAcademicYear')->name('verify.academic_year');
Route::get('verify/academic_year/resend', 'Verify\AcademicYearController@resendMailVerifyAcademicYear')->name('verify.academic_year.resend');
Route::get('verify/user', 'Verify\UserController@verifyUser')->name('verify.user');
Route::get('verify/user/resend', 'Verify\UserController@resendMailVerifyUser')->name('verify.user.resend');

/**
 * Dashboard for students
 */

Route::get('dashboard/academic_years/verified', 'DashboardController@academicYearsVerified')->name('dashboard.academic_years.verified')->middleware('auth');
Route::get('dashboard/academic_years/unverified', 'DashboardController@academicYearsUnverified')->name('dashboard.academic_years.unverified')->middleware('auth');
Route::get('dashboard/academic_years/archive', 'DashboardController@academicYearsArchive')->name('dashboard.academic_years.archive')->middleware('auth');

Route::get('dashboard/academic_years/{academic_year}/payouts/create', 'DashboardController@academicYearsPayoutsCreate')->name('dashboard.academic_years.payouts.create')->middleware('auth');
Route::post('dashboard/academic_years/{academic_year}/payouts', 'PayoutController@store')->name('dashboard.academic_years.payouts.store')->middleware('auth');
Route::get('dashboard/payouts', 'DashboardController@payoutsIndex')->name('dashboard.payouts')->middleware('auth');

/**
* AcademicYear, Updates, Goals, Campaign Controllers
*/

Route::post('academic_years/validate_goal','AcademicYearController@validate_goal')->name('academic_year.validate_goal');
Route::post('academic_years/validate', 'AcademicYearController@validate_year')->name('academic_year.validate');
Route::get('academic_years/thanks','AcademicYearController@register_success');
Route::resource('academic_years', 'AcademicYearController');

Route::resource('academic_years.updates', 'AcademicYear\UpdatesController', ['except' => ['index', 'show']]);
Route::resource('academic_years.goals', 'AcademicYear\GoalsController', ['except' => ['index', 'show']]);
Route::put('academic_years/{academic_year}/campaign/update', 'AcademicYear\CampaignController@update')->name('academic_years.campaign.update');
Route::get('academic_years/{academic_year}/campaign/edit', 'AcademicYear\CampaignController@edit')->name('academic_years.campaign.edit');

//Route::resource('academic_years.donations', 'DonationController', ['only' => ['create', 'store']]);

/**
 * Donation Routes
 */
Route::get('academic_years/{id}/donation', 'DonationController@getDonation')->name('donation.get');
Route::post('academic_years/{id}/donation', 'DonationController@postDonation')->name('donation.post');
Route::get('donation/status', 'DonationController@status')->name('donation.status');
Route::post('donation/webhook', 'DonationController@webhook')->name('donation.webhook');

//Test mail
Route::get('mail', 'HomeController@mail');

/*Route::get('projects','ProjectController@index')->name('projects.index');
Route::get('projects/create','ProjectController@create')->name('projects.create');
Route::post('projects','ProjectController@store')->name('projects.store');
Route::get('projects/{project}','ProjectController@show')->name('projects.show');*/



