<?php


// use App\Http\Controllers\API\UserRewardController as APIUserRewardController;

use Illuminate\Http\Request;

use App\Http\Controllers\Admin\HelpLinkController;
use App\Http\Controllers\API\User\MainController;
use App\Http\Controllers\API\User\DetailController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\GigController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\TelecallingController;
use App\Http\Controllers\API\RazorpayController;
use App\Http\Controllers\API\WalletTransactionController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\OfferwallUserController;
use App\Http\Controllers\API\OfferwallUserOfferController;
use App\Http\Controllers\API\UserRewardController;
use App\Http\Controllers\API\GameController;

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

Route::prefix('user')->group(function () {
    Route::post('login', [MainController::class, 'login']);
    Route::get('userexist', [MainController::class, 'userexist']);
    Route::post('register', [MainController::class, 'register']);
    Route::post('details', [DetailController::class, 'details']);
    Route::post('skills', [DetailController::class, 'skills']);
    Route::post('edu', [DetailController::class, 'edu']);
    Route::post('exp', [DetailController::class, 'exp']);
    Route::post('projects', [DetailController::class, 'projects']);
    Route::post('skillsUpdate', [DetailController::class, 'skillsUpdate']);
    Route::post('eduUpdate', [DetailController::class, 'eduUpdate']);
    Route::post('expUpdate', [DetailController::class, 'expUpdate']);
    Route::post('projectsUpdate', [DetailController::class, 'projectsUpdate']);
    Route::post('skillsDelete', [DetailController::class, 'skillsDelete']);
    Route::post('eduDelete', [DetailController::class, 'eduDelete']);
    Route::post('expDelete', [DetailController::class, 'expDelete']);
    Route::post('projectsDelete', [DetailController::class, 'projectsDelete']);
    Route::post('hobbiesUpdate', [DetailController::class, 'hobbyUpdate']);
    Route::post('achievementsUpdate', [DetailController::class, 'achUpdate']);
    Route::post('socialUpdate', [DetailController::class, 'socialUpdate']);
    Route::post('profileUpdate', [DetailController::class, 'profileUpdate']);
    Route::post('profileImage', [DetailController::class, 'profileImage']);
    Route::post('passUpdate', [DetailController::class, 'passUpdate']);
    Route::post('loginTC', [MainController::class, 'loginTC']);
    Route::post('verifyMobile', [MainController::class, 'verifyMobile']);
    Route::post('forgot-password', [MainController::class, 'forgotPassword']);
    Route::post('email-verified', [MainController::class, 'emailVerified']);
    Route::post('storeRef', [DetailController::class, 'storeRef']);
    Route::post('get-session', [MainController::class, 'getSession']);

    Route::post('jprojects', [DetailController::class, 'jprojects']);
    Route::post('gigs', [DetailController::class, 'gigs']);
    Route::post('campaigns', [DetailController::class, 'campaigns']);

    Route::post('withdrawMethod', [DetailController::class, 'withdrawMethod']);
    Route::post('bannerMethod', [DetailController::class, 'bannerMethod']);
    Route::post('withdraw', [DetailController::class, 'withdraw']);
    Route::post('transactions', [DetailController::class, 'transactions']);
    Route::post('allTransactions', [DetailController::class, 'allTransactions']);
});
Route::group([], function () {
    // Project Routes
    Route::post('projects', [ProjectController::class, 'list']);
    Route::post('project/details', [ProjectController::class, 'details']);
    Route::post('project/apply', [ProjectController::class, 'apply']);
    Route::post('project/proofs', [ProjectController::class, 'proofs']);
    Route::post('mobileContent', [ProjectController::class, 'mobile']);

    // Gig Routes
    Route::post('gigs', [GigController::class, 'list']);
    Route::post('gig/details', [GigController::class, 'details']);
    Route::post('gig/apply', [GigController::class, 'apply']);

    // Gig Proof Routes
    Route::post('gig/proof/fb', [GigController::class, 'prooffb']);
    Route::post('gig/proof/wa', [GigController::class, 'proofwa']);
    Route::post('gig/proof/insta', [GigController::class, 'proofinsta']);
    Route::post('gig/proof/yt', [GigController::class, 'proofyt']);
    Route::post('gig/proof/instap', [GigController::class, 'proofinstap']);
    Route::post('gig/proof/os', [GigController::class, 'proofos']);
    Route::post('gig/proof/ar', [GigController::class, 'proofar']);
    Route::post('gig/proof/ls', [GigController::class, 'proofls']);
    Route::post('gig/proofs', [GigController::class, 'proofs']);

    // Campaign Routes
    Route::post('campaigns', [CampaignController::class, 'list']);
    Route::post('campaign/details', [CampaignController::class, 'details']);
    Route::post('campaign/apply', [CampaignController::class, 'apply']);
    // Route::post('campaign/proof', [CampaignController::class, 'proofs']);

    // Telecalling Routes
    Route::post('telecallings', [TelecallingController::class, 'list']);
    Route::post('telecalling/details', [TelecallingController::class, 'details']);
    Route::post('telecalling/apply', [TelecallingController::class, 'apply']);
    Route::post('telecalling/applications', [TelecallingController::class, 'applications']);
    Route::post('telecalling/status', [TelecallingController::class, 'status']);
    Route::post('telecalling/feedback', [TelecallingController::class, 'feedback']);

    // Razorpay Routes
    Route::post('razorp/addc', [RazorpayController::class, 'add_contact']);
    Route::post('razorp/fundid', [RazorpayController::class, 'get_fund_id']);
    Route::post('razorp/withdraw', [RazorpayController::class, 'withdraw']);

    // Other Routes
    Route::post('wallet-transactions', [WalletTransactionController::class, 'store']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::post('offerwall-users', [OfferwallUserController::class, 'store']);
    Route::post('offerwall-user-offer', [OfferwallUserOfferController::class, 'store']);
    Route::post('user-rewards', [UserRewardController::class, 'store']);
    Route::get('games', [GameController::class, 'fetchGames']);
});

// // Create a new reward record
// Route::post('test','TrueCallerController@login');
// Route::get("config", "ConfigurationController@fetchConfiguration");

Route::get('/help-links', [HelpLinkController::class, 'apiIndex']);


// Route::get('acc_details',"RazorpayController@create_contact");
// Route::post('acc_details',"RazorpayController@add_contact");
// Route::post('givereward/',"RazorpayController@givereward");

// //pubscale
// Route::post('transactions', [TransactionController::class, 'store']);
// Route::post('offerwall-users', [OfferwallUserController::class, 'store']);
// Route::post('offerwall-user-offer', [OfferwallUserOfferController::class, 'store']);

