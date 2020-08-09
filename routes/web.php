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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', 'PlanNotifierController@getCompletedPlans');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/api/password/find/{token}', 'Auth\ResetPasswordController@showResetForm');

Route::resource('referral', 'ReferralsController');
//Route::resource('referral', 'LinksController');

/*===============================
|
|This routes manages the information
|on the main home page.
|===============================
|
|
|
 */


Route::group(['prefix' => '/'], function () {


    Route::get('solution/{type}', function () {
        return view('solution');
    });
    Route::get('solution', function () {
        return view('solution');
    });
    Route::get('faq', function () {
        return view('faqs');
    });
    Route::get('privacy-policy', function () {
        return view('privacy-policy');
    });
    Route::get('terms-of-service', function () {
        return view('terms-of-service');
    });
    Route::get('about', function () {
        return view('about');
    });


    //React route
    Route::get('activity', function () {
        return view('home');
    });
    Route::get('youth-goals', function () {
        return view('home');
    });
    Route::get('steady-growth', function () {
        return view('home');
    });

    Route::get('save', function () {
        return view('home');
    });

    Route::get('new-plan', function () {
        return view('home');
    });

    Route::get('personal', function () {
        return view('home');
    });

    Route::get('withdrawal', function () {
        return view('home');
    });

    Route::get('next-kin', function () {
        return view('home');
    });

    Route::get('payments', function () {
        return view('home');
    });


    Route::get('customers', function () {
        return view('home');
    });


});


/*===============================
|
|This routes controls general
|information about the user
|===============================
|
|
|
*/

Route::group(['prefix' => '/home'], function () {


    Route::get('/user', 'HomeController@getUser');

    Route::post('/user', 'HomeController@updateUser');

    Route::get('/kin', 'HomeController@getNextKin');
    Route::post('/kin', 'HomeController@saveNextKin');

    Route::get('/summary', 'HomeController@getSummary');
    Route::get('/steadyPlan', 'PlanController@steadyPlan');
    Route::get('/youthPlan', 'PlanController@youthPlan');
    Route::get('/youthSavings/{planId}', 'PlanController@youthSavings');
    Route::get('/steadySavings/{planId}', 'PlanController@steadySavings');

    Route::post('/updateYouthGoals', 'PlanController@updateYouthGoals');
    Route::post('/updateSteadyGrowth', 'PlanController@updateSteadyGrowth');
    Route::post('/saveNow', 'PaymentsController@saveUserAmount');

    Route::get('/getPlans', 'PlanController@getPlans');

    Route::get('/payOptions', 'PlanController@payOptions');
    Route::get('/removeCard/{cardId}', 'PlanController@removeCard');
    Route::get('/sendConfirmation', 'PlanController@sendConfirmation');
    Route::post('/transferRecipient', 'PlanController@transferRecipient');

    Route::get('/userWithdrawals', 'PlanController@getUserWithdrawals');

    Route::post('/initiateTransfer', 'PlanController@initiateTransfer');
    Route::post('/changePassword', 'HomeController@changePassword');

});


/*===============================
|
|This routes controls the different
|plan set up
|===============================
|
|
|
 */
Route::group(['prefix' => '/setup'], function () {


    Route::get('/paystackDetails', 'PlanController@payStackDetails');
    Route::get('/paymentStack/{trxref}', 'PaymentsController@handleGatewayCall');
    Route::get('/paymentStackSubsequent/{trxref}', 'PaymentsController@handleGatewaySubsequentCall');

    Route::post('/planSetupUrl', 'PlanController@savePlanSetup');
    Route::post('/newPlanSetupUrl', 'PlanController@saveNewPlanSetup');
    Route::post('/youthGoalSetup', 'PlanController@youthGoalSetup');
    Route::post('/steadyGrowthSetup', 'PlanController@steadyGrowthSetup');


});

/*===============================
|
|This routes controls the different
|plan set up
|===============================
|
|
|
 */
Route::group(['prefix' => '/deductions'], function () {


    Route::get('/initialize-youths', 'ScheduleController@initializeYouthsDeductions');
    Route::get('/initialize-steady', 'ScheduleController@initializeSteadyDeductions');
    Route::get('/lock-matured-plans', 'ScheduleController@lockMaturedPlan');

    Route::get('/process-youths', 'ScheduleController@processYouthsDeductions');
    Route::get('/process-steady', 'ScheduleController@processSteadyDeductions');

    Route::get('/test-deduce', 'ScheduleController@deductions');

    Route::get('/next/{planId}', 'ScheduleController@nextDate');


});


/*===============================
|
|This routes controls the admin page
|===============================
|
|
|
 */

Route::group(['prefix' => 'customers'], function () {

    Route::get('/', 'AdminController@customers');
    Route::get('/search', 'AdminController@searchCustomers');

});

Route::get('dashboard', 'AdminController@dashboard');


Route::group(['prefix' => 'plans'], function () {

    Route::get('/youths', 'AdminController@youthGoals');

    Route::get('/youth-savings-history/{id}/{userId}', 'AdminController@youthSavingsHistory');

    Route::get('/steady-savings-history/{id}/{userId}', 'AdminController@steadySavingsHistory');

    Route::get('/steady', 'AdminController@steadyPlans');

});


