<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserRewardController;
// use App\Http\Controllers\API\UserRewardController as APIUserRewardController;
use App\Http\Controllers\Api\WalletTransactionController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\HelpLinkController;

use Illuminate\Support\Facades\Route;

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

Route::namespace('API\User')->prefix('user')->group(function(){
    Route::post('login','MainController@login');
    Route::get('userexist','MainController@userexist');
    Route::post('register','MainController@register');
    Route::post('details','DetailController@details');
    Route::post('skills','DetailController@skills');
    Route::post('edu','DetailController@edu');
    Route::post('exp','DetailController@exp');
    Route::post('projects','DetailController@projects');
    Route::post('skillsUpdate','DetailController@skillsUpdate');
    Route::post('eduUpdate','DetailController@eduUpdate');
    Route::post('expUpdate','DetailController@expUpdate');
    Route::post('projectsUpdate','DetailController@projectsUpdate');
    Route::post('skillsDelete','DetailController@skillsDelete');
    Route::post('eduDelete','DetailController@eduDelete');
    Route::post('expDelete','DetailController@expDelete');
    Route::post('projectsDelete','DetailController@projectsDelete');
    Route::post('hobbiesUpdate','DetailController@hobbyUpdate');
    Route::post('achievementsUpdate','DetailController@achUpdate');
    Route::post('socialUpdate','DetailController@socialUpdate');
    Route::post('profileUpdate','DetailController@profileUpdate');
    Route::post('profileImage','DetailController@profileImage');
    Route::post('passUpdate','DetailController@passUpdate');
    Route::post('loginTC','MainController@loginTC');
    Route::post('verifyMobile','MainController@verifyMobile');
    Route::post('forgot-password','MainController@forgotPassword');
    Route::post('email-verified','MainController@emailVerified');
    Route::post('storeRef','DetailController@storeRef');
    Route::post('get-session','MainController@getSession');

    Route::post('jprojects','DetailController@jprojects');
    Route::post('gigs','DetailController@gigs');
    Route::post('campaigns','DetailController@campaigns');

    Route::post('withdrawMethod','DetailController@withdrawMethod');
    Route::post('bannerMethod','DetailController@bannerMethod');
    Route::post('withdraw','DetailController@withdraw');
    Route::post('transactions','DetailController@transactions');
    Route::post('allTransactions','DetailController@allTransactions');
});
Route::namespace('API')->group(function(){
    Route::post('projects','ProjectController@list');
    Route::post('project/details','ProjectController@details');
    Route::post('project/apply','ProjectController@apply');
    Route::post('project/proofs','ProjectController@proofs');
    Route::post('mobileContent','ProjectController@mobile');

    Route::post('gigs','GigController@list');
    Route::post('gig/details','GigController@details');
    Route::post('gig/apply','GigController@apply');

    Route::post('gig/proof/fb','GigController@prooffb');
    Route::post('gig/proof/wa','GigController@proofwa');
    Route::post('gig/proof/insta','GigController@proofinsta');
    Route::post('gig/proof/yt','GigController@proofyt');
    Route::post('gig/proof/instap','GigController@proofinstap');
    Route::post('gig/proof/os','GigController@proofos');
    Route::post('gig/proof/ar','GigController@proofar');
    Route::post('gig/proof/ls','GigController@proofls');
    Route::post('gig/proofs','GigController@proofs');

    Route::post('campaigns','CampaignController@list');
    Route::post('campaign/details','CampaignController@details');
    Route::post('campaign/apply','CampaignController@apply');
    // Route::post('campaign/proof','CampaignController@proofs');

    Route::post("telecallings","TelecallingController@list");
    Route::post("telecalling/details","TelecallingController@details");
    Route::post("telecalling/apply","TelecallingController@apply");
    Route::post("telecalling/applications","TelecallingController@applications");
    Route::post("telecalling/status","TelecallingController@status");
    Route::post("telecalling/feedback","TelecallingController@feedback");

    Route::post("razorp/addc","RazorpayController@add_contact");
    Route::post("razorp/fundid","RazorpayController@get_fund_id");
    Route::post("razorp/withdraw","RazorpayController@withdraw");
    Route::post('wallet-transactions',[WalletTransactionController::class,'store']);
    Route::post('transactions','TransactionController@store');
    Route::post('offerwall-users','OfferwallUserController@store');
    Route::post('offerwall-user-offer','OfferwallUserOfferController@store');
    Route::post('user-rewards', [UserRewardController::class, 'store']);
    Route::get('/games', [GameController::class, 'fetchGames']);

});
// Create a new reward record
Route::post('test','TrueCallerController@login');
Route::get("config", "ConfigurationController@fetchConfiguration");

Route::get('/help-links', [HelpLinkController::class, 'apiIndex']);


// Route::get('acc_details',"RazorpayController@create_contact");
// Route::post('acc_details',"RazorpayController@add_contact");
// Route::post('givereward/',"RazorpayController@givereward");

// //pubscale
// Route::post('transactions', [TransactionController::class, 'store']);
// Route::post('offerwall-users', [OfferwallUserController::class, 'store']);
// Route::post('offerwall-user-offer', [OfferwallUserOfferController::class, 'store']);

