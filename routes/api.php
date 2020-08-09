<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');


// forget password
//Route::post('forget', 'Api\ApiForgotPasswordController@getResetToken');

//reset password
//Route::post('password/reset', 'Api\ApiResetPasswordController@reset');

//user verification
//Route::get('email/verify/{token}', 'Api\ApiVerificationController@verify');

Route::group([
    'namespace' => 'Api',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('resend', 'ApiForgotPasswordController@sendResetLinkEmail');
    //Route::get('verify/{token}', 'ApiResetPasswordController@find');
    Route::get('find/{email}', 'ApiResetPasswordController@findToken');
    Route::post('reset', 'ApiResetPasswordController@reset');
});

/*Route::group([
    'namespace' => 'Api',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('resend', 'ApiResetPasswordController@create');
    Route::get('verify/{token}', 'ApiResetPasswordController@find');
    Route::post('reset', 'ApiResetPasswordController@reset');
});
*/

Route::group(['prefix' => 'home'], function () {


    Route::middleware('auth:api')->get('/user', 'Api\ApiHomeController@getUser');

    Route::middleware('auth:api')->post('/user', 'Api\ApiHomeController@updateUser');

    Route::middleware('auth:api')->get('/kin', 'Api\ApiHomeController@getNextKin');
    Route::middleware('auth:api')->post('/kin', 'Api\ApiHomeController@saveNextKin');

    Route::middleware('auth:api')->get('/summary', 'Api\ApiHomeController@getSummary');

    Route::middleware('auth:api')->get('/steadyPlan', 'Api\ApiPlanController@steadyPlan');
    Route::middleware('auth:api')->get('/youthPlan', 'Api\ApiPlanController@youthPlan');
    Route::middleware('auth:api')->get('/youthSavings/{planId}', 'Api\ApiPlanController@youthSavings');
    Route::middleware('auth:api')->get('/steadySavings/{planId}', 'Api\ApiPlanController@steadySavings');

    Route::middleware('auth:api')->post('/updateYouthGoals', 'Api\ApiPlanController@updateYouthGoals');
    Route::middleware('auth:api')->post('/updateSteadyGrowth', 'Api\ApiPlanController@updateSteadyGrowth');
    Route::middleware('auth:api')->post('/saveNow', 'Api\ApiPaymentsController@saveUserAmount');

    Route::middleware('auth:api')->get('/getPlans', 'Api\ApiPlanController@getPlans');

    Route::middleware('auth:api')->get('/payOptions', 'Api\ApiPlanController@payOptions');
    Route::middleware('auth:api')->get('/removeCard/{cardId}', 'Api\ApiPlanController@removeCard');
    Route::middleware('auth:api')->get('/cards', 'Api\ApiPlanController@userCards');
    Route::middleware('auth:api')->get('/sendConfirmation', 'Api\ApiPlanController@sendConfirmation');
    Route::middleware('auth:api')->post('/transferRecipient', 'Api\ApiPlanController@transferRecipient');

    Route::middleware('auth:api')->get('/userWithdrawals', 'Api\ApiPlanController@getUserWithdrawals');

    Route::middleware('auth:api')->post('/initiateTransfer', 'Api\ApiPlanController@initiateTransfer');
    Route::middleware('auth:api')->post('/changePassword', 'Api\ApiHomeController@changePassword');

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

Route::group(['prefix'=>'plan'], function (){

    Route::middleware('auth:api')->post('/firstSavings', 'Api\ApiPlanController@createFirstSavings');

    Route::middleware('auth:api')->get('/paystackDetails', 'Api\ApiPlanController@payStackDetails');

    Route::middleware('auth:api')->get('/banks', 'Api\ApiPlanController@getBanks');

    Route::middleware('auth:api')->get('/paymentStack/{trxref}', 'Api\ApiPaymentsController@handleGatewayCall');
    Route::middleware('auth:api')->get('/paymentStackSubsequent/{trxref}', 'Api\ApiPaymentsController@handleGatewaySubsequentCall');

    Route::middleware('auth:api')->post('/planSetupUrl', 'Api\ApiPlanController@savePlanSetup');

    Route::middleware('auth:api')->post('/newPlanSetup', 'Api\ApiPlanController@saveNewPlanSetup');

    Route::middleware('auth:api')->post('/youthGoalSetup', 'Api\ApiPlanController@youthGoalSetup');

    Route::middleware('auth:api')->post('/steadyGrowthSetup', 'Api\ApiPlanController@steadyGrowthSetup');


});