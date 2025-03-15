<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManagerController as Manager;
use App\Career;
use App\Employer;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CampaignCategoryController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HelpLinkController;
use App\Http\Controllers\Admin\JobApplicantController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Admin\MemberManageController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\TelecallingController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\BformController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\Employer\CampaignController as EmployerCampaignController;
use App\Http\Controllers\Employer\HomeController as EmployerHomeController;
use App\Http\Controllers\JobApplicantController as ControllersJobApplicantController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\GigController as EmployerGigController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Manager\CampaignController as ManagerCampaignController;
use App\Http\Controllers\Manager\EmployerController as ManagerEmployerController;
use App\Http\Controllers\Manager\HomeController as ManagerHomeController;
use App\Http\Controllers\Manager\MainController;
use App\Http\Controllers\Manager\TelecallingController as ManagerTelecallingController;
use App\Http\Controllers\RazorpayController;

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

Route::get('privacy-policy',function(){
    return view('privacy-policy');
})->name('privacy-policy');
Route::get('refund-policy',function(){
    return view('refund-policy');
})->name('refund-policy');
Route::get('return-policy',function(){
    return view('return-policy');
})->name('return-policy');
Route::get('shipping-policy',function(){
    return view('shipping-policy');
})->name('shipping-policy');
Route::get('terms-policy',function(){
    return view('terms-policy');
})->name('terms-policy');
Route::get('deleteaccount',function(){
    return view('deleteaccount');
})->name('deleteaccount');
// Route::get('user/email-verified/{id}','User\DashboardController@email_verified');
Route::get('user/email-verified/{id}',[UserDashboardController::class,'email_verified']);
// Admin
// Route::get('beta','Admin\HomeController@index')->name('admin');
// Route::post('beta','Admin\HomeController@login')->name('admin.login');
Route::get('beta',[HomeController::class,'index'])->name('admin');
Route::post('beta',[HomeController::class,'login'])->name('admin.login');


// playstore link 
// Route::get('signin/{id}','Admin\HomeController@signin')->name('signin');
Route::get('signin/{id}',[HomeController::class,'signin'])->name('signin');

Route::get('admin/managers', [Manager::class, 'index'])->name('admin.managers');
Route::post('admin/manager/create',[Manager::class, 'create'])->name('admin.manager.create'); 
Route::post('admin/manager/delete',[Manager::class, 'delete'])->name('admin.manager.delete'); 

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');

        Route::get('help',[HelpLinkController::class,'index'])->name('help.index');
        Route::post('help',[HelpLinkController::class,'store'])->name('help.store');

      // Applicants Routes
        Route::get('applicants', [JobApplicantController::class, 'index'])->name('applicants.index');
        Route::post('applicants/{id}/mark-called', [JobApplicantController::class, 'markAsCalled'])->name('applicants.mark-called');


// Bforms Routes
Route::get('bforms', [HomeController::class, 'bformv'])->name('bforms');
Route::post('bform/delete', [HomeController::class, 'delete'])->name('bform.delete');

// Employer Routes
Route::get('create', [EmployerController::class, 'create'])->name('employer.create');
Route::post('create', [EmployerController::class, 'store'])->name('employer.create');

// Dashboard Routes
Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Change Password Routes
Route::get('change-password', [HomeController::class, 'changePassword'])->name('changePassword');
Route::post('change-password', [HomeController::class, 'PasswordUpdate'])->name('changePassword');

// Logout Route
Route::post('logout', [HomeController::class, 'logout'])->name('logout');

    // Campaigns
    Route::get('project', [MissionController::class, 'index'])->name('missions');
    Route::get('project/create', [MissionController::class, 'creater'])->name('mission.create');
    Route::post('project/create', [MissionController::class, 'create'])->name('mission.create');
    Route::post('project/editform', [MissionController::class, 'editform'])->name('mission.editform');
    Route::get('project/addform/{id}', [MissionController::class, 'addform'])->name('mission.addform');
    Route::put('project/updateform/{id}', [MissionController::class, 'updateform'])->name('mission.updateform');
    Route::post('storeForm', [MissionController::class, 'storeForm'])->name('mission.storeForm');
    Route::post('project/delete', [MissionController::class, 'delete'])->name('mission.delete');
    Route::get('project/applications/{id}', [MissionController::class, 'applications'])->name('mission.applications');
    Route::get('project/applications/accept/{id}', [MissionController::class, 'accept'])->name('mission.accept');
    Route::get('project/applications/reject/{id}', [MissionController::class, 'reject'])->name('mission.reject');
    Route::get('project/response/{id}', [MissionController::class, 'response'])->name('mission.response');
    Route::post('project/response/accept', [MissionController::class, 'acceptResp'])->name('mission.acceptResp');
    Route::post('project/response/reject', [MissionController::class, 'rejectResp'])->name('mission.rejectResp');
    Route::post('campaigns/make-mobile', [MissionController::class, 'makeMobile'])->name('mission.make-mobile');
    Route::post('campaigns/undo-mobile', [MissionController::class, 'undoMobile'])->name('mission.undo-mobile');
    Route::get('campaigns/projectstatus/{id}', [MissionController::class, 'projectStatus'])->name('mission.project_status');
    Route::get('edit-campaign/{id}', [MissionController::class, 'EditProject'])->name('mission.edit_project');
    Route::post('edit-campaign/{id}', [MissionController::class, 'UpdateProject'])->name('mission.update');
    Route::post('campaigns/projectstatus/{id}', [MissionController::class, 'projectStatus'])->name('mission.projecct_status');

    //Gig
    Route::get('gig',[AdminCampaignController::class,'ShowAllCampaign'])->name('campaign.all');
    Route::get('pending-gig', 'CampaignController@pendings')->name('campaign.pendings');
    Route::get('backup-gig', [AdminCampaignController::class, 'BackupGig'])->name('campaign.backup');
Route::get('gig-log', [AdminCampaignController::class, 'ShowCampaignLog'])->name('campaign.log');
Route::get('create-gig', [AdminCampaignController::class, 'CreateCampaign'])->name('campaign.create');
Route::post('create-gig', [AdminCampaignController::class, 'StoreCampaign'])->name('store.campaign');
Route::get('edit-gig/{id}', [AdminCampaignController::class, 'EditCampaign'])->name('campaign.edit');
Route::post('edit-gig/{id}', [AdminCampaignController::class, 'UpdateCampaign'])->name('update.campaign');
Route::get('approve-gig/{id}', [AdminCampaignController::class, 'approveCampaign'])->name('campaignp.approve');
Route::get('reject-gig/{id}', [AdminCampaignController::class, 'rejectCampaign'])->name('campaignp.reject');
Route::post('gig-delete', [AdminCampaignController::class, 'DeleteCampaign'])->name('campaign.delete');
Route::post('backupgig-delete', [AdminCampaignController::class, 'DeleteBackupCampaign'])->name('campaign.backupdelete');
Route::get('gig-applications/{id}', [AdminCampaignController::class, 'Campaignapp'])->name('campaign.app');
Route::get('gig-applications/{jid}/approve/{uid}', [AdminCampaignController::class, 'Campaignapprove'])->name('campaign.approve');
Route::get('gig-applications/{jid}/reject/{uid}', [AdminCampaignController::class, 'Campaignreject'])->name('campaign.reject');
Route::get('gig-proofs/{jid}/view/{uid}', [AdminCampaignController::class, 'viewproof'])->name('campaign.viewproof');
Route::get('gig-proofs/{jid}/view/{uid}/accept', [AdminCampaignController::class, 'acceptproof'])->name('campaign.acceptproof');
Route::get('gig-proofs/{jid}/view/{uid}/reject', [AdminCampaignController::class, 'rejectproof'])->name('campaign.rejectproof');
Route::post('gig/make-mobile', [AdminCampaignController::class, 'makeMobile'])->name('campaign.make-mobile');
Route::post('gig/undo-mobile', [AdminCampaignController::class, 'undoMobile'])->name('campaign.undo-mobile');
Route::get('gig/details/{id}', [AdminCampaignController::class, 'details'])->name('campaign.gig-details');
Route::get('gig/gigstatus/{id}', [AdminCampaignController::class, 'statusCampaign'])
->name('campaign.status');
Route::get('gig/showstatus/{id}', [AdminCampaignController::class, 'toggleShowStatus'])->name('campaign.showstatus');
Route::post('gig/toggle-status/{id}', [AdminCampaignController::class, 'toggleViewStatus'])->name('campaign.toggleStatus');
Route::post('gig/set-priority', [AdminCampaignController::class, 'setPriority'])->name('campaign.set-priority');
Route::get('gig/{id}/download-backup-proofs', [AdminCampaignController::class, 'export_excel_for_backup'])->name('campaign.backup_accepted_proof');
Route::get('gig/{id}/download-backup-rejectproofs', [AdminCampaignController::class, 'export_reject_excel_for_backup'])->name('campaign.backup_rejected_proof');
Route::post('tasks/update-top', [AdminCampaignController::class, 'updateTopTasks'])->name('tasks.updateTop');
Route::post('/gigs/{id}/toggle-show-first', [AdminCampaignController::class, 'toggleShowFirst'])->name('campaign.showfirst');
Route::post('/gigs/{id}/toggle-show-second', [AdminCampaignController::class, 'toggleShowSecond'])->name('campaign.showsecond');




    //campaign category
    Route::resource('campaign_category', CampaignCategoryController::class);

   // Projects
Route::get('pending-project', [AdminJobController::class, 'pending'])->name('job.pending');
Route::get('all-project', [AdminJobController::class, 'all'])->name('job.all');
Route::post('approve-project', [AdminJobController::class, 'approve'])->name('job.approve');
Route::post('delete-project', [AdminJobController::class, 'delete'])->name('job.delete');
Route::post('project/make-mobile', [AdminJobController::class, 'makeMobile'])->name('job.make-mobile');
Route::post('project/undo-mobile', [AdminJobController::class, 'undoMobile'])->name('job.undo-mobile');
Route::get('project/internshipstatus/{id}', [AdminJobController::class, 'projectStatus'])->name('job.campaign_status');
Route::get('project/toggle-visibility/{id}', [AdminJobController::class, 'toggleVisibility'])->name('job.toggle_visibility');

Route::get('/manage-users', [ManagerHomeController::class, 'manageUsers'])->name('manage.users');


    // Member Manage
Route::get('member', [MemberManageController::class, 'ShowAllMember'])->name('member.all');
Route::get('member-create', [MemberManageController::class, 'create'])->name('member.create');
Route::post('member-create', [MemberManageController::class, 'store'])->name('member.create');
Route::post('member/update-balance', [MemberManageController::class, 'updateBalance'])->name('member.updateBalance');
Route::get('pending-regs', [MemberManageController::class, 'pending'])->name('member.pending');
Route::get('pending-regs/approve/{id}', [MemberManageController::class, 'approve'])->name('member.approve');
Route::get('pending-regs/reject/{id}', [MemberManageController::class, 'reject'])->name('member.reject');
Route::get('member/{id}', [MemberManageController::class, 'ShowMemberDetails'])->name('member.details');
Route::post('member-update', [MemberManageController::class, 'MemberUpdate'])->name('member.update');
Route::post('member-delete', [MemberManageController::class, 'MemberDelete'])->name('member.delete');
Route::post('member-isBlocked', [MemberManageController::class, 'MemberisBlocked'])->name('member.isBlocked');
Route::get('member-filter', [MemberManageController::class, 'ShowAllMember'])->name('member.filter');

Route::get('withdraw-report/{id}', [MemberManageController::class, 'WithdrawReport'])->name('member.withdraw_report');
Route::get('campaign-report/{id}', [MemberManageController::class, 'CampaignReport'])->name('member.campaign_report');
Route::get('project-report/{id}', [MemberManageController::class, 'projectReport'])->name('member.project_report');
Route::get('gig-report/{id}', [MemberManageController::class, 'gigReport'])->name('member.gig_report');
Route::get('member/export/excel', [MemberManageController::class, 'excel_export'])->name('member.export');
Route::get('member/export/referrals', [MemberManageController::class, 'excel_referrals'])->name('member.export.referrals');
   // Withdraw Methods
Route::get('withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
Route::post('withdraw/store', [WithdrawController::class, 'store'])->name('withdraw.store');
Route::put('withdraw/update/{id}', [WithdrawController::class, 'update'])->name('withdraw.update');
Route::delete('withdraw/destroy', [WithdrawController::class, 'destroy'])->name('withdraw.destroy');
Route::post('process-payout/{id}', [WithdrawController::class, 'processPayout'])->name('process-payout');


Route::get('withdraw-filter', [DashboardController::class, 'ShowWithdrawLog'])->name('withdraw.filterupi');
Route::get('withdraw-request', [DashboardController::class, 'ShowWithdrawRequest'])->name('show.withdraw.request');
Route::get('withdraw-log', [DashboardController::class, 'ShowWithdrawLog'])->name('show.withdraw.log');
Route::post('withdraw-approve', [DashboardController::class, 'WithdrawApproved'])->name('withdraw.approve');
Route::post('withdraw-reject', [DashboardController::class, 'WithdrawReject'])->name('withdraw.reject');

    
   // Banner
Route::get('banner', [BannerController::class, 'index'])->name('banner.index');
Route::post('banner/store', [BannerController::class, 'store'])->name('banner.store');
Route::put('banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
Route::delete('banner/destroy', [BannerController::class, 'destroy'])->name('banner.destroy');

    
// Excel Exports
Route::get('project/export', [AdminJobController::class, 'export_excel'])->name('project.export');
Route::get('gig/export', [AdminCampaignController::class, 'export_excel'])->name('gig.export');
Route::get('gig/export/apps/{id}', [AdminCampaignController::class, 'export_apps'])->name('gig.apps.export');
Route::get('campaign/export', [MissionController::class, 'export_excel'])->name('campaign.export');
Route::get('campaign/export/apps/{id}', [MissionController::class, 'export_apps'])->name('campaign.apps.export');
Route::get('withdraw/export', [WithdrawController::class, 'export_excel'])->name('withdraw.export');
Route::get('gigapp/export-status', [MemberManageController::class, 'exportGigAppStatus'])->name('gigapp.export.status');

   // Employers
Route::get('employers', [EmployerController::class, 'index'])->name('employers');
Route::post('employer/login', [EmployerController::class, 'login'])->name('employer.login');
Route::post('employer-delete', [EmployerController::class, 'delete'])->name('employer.delete');

// Telecallings
Route::get('telecallings', [TelecallingController::class, 'index'])->name('telecallings');
Route::get('telecallings/create', [TelecallingController::class, 'create'])->name('telecalling.create');
Route::post('telecallings/create', [TelecallingController::class, 'createPost'])->name('telecalling.create');
Route::post('telecallings/delete', [TelecallingController::class, 'delete'])->name('telecalling.delete');
Route::get('telecalling/applications/{id}', [TelecallingController::class, 'applications'])->name('telecalling.applications');
Route::post('telecalling/distribute', [TelecallingController::class, 'distribute'])->name('telecalling.distribute');
Route::post('telecalling/application/select', [TelecallingController::class, 'select'])->name('telecalling.select');
Route::post('telecalling/application/reject', [TelecallingController::class, 'reject'])->name('telecalling.reject');
Route::get('telecalling/application/view-data/{tid}/{uid}', [TelecallingController::class, 'viewData'])->name('telecalling.viewdata');
Route::get('telecalling/application/view-feedback/{id}', [TelecallingController::class, 'feedback'])->name('telecalling.feedback');
    
  // Careers
Route::get('jobs', [CareerController::class, 'index'])->name('jobs.index');
Route::get('jobs/create', [CareerController::class, 'create'])->name('jobs.create');
Route::post('jobs/store', [CareerController::class, 'store'])->name('jobs.store');
Route::get('jobs/{job}/edit', [CareerController::class, 'edit'])->name('jobs.edit');
Route::put('jobs/{job}/update', [CareerController::class, 'update'])->name('jobs.update');
Route::delete('jobs/{job}/destroy', [CareerController::class, 'destroy'])->name('jobs.destroy');

});

    
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('bform', [BformController::class, 'bform'])->name('bform');
Route::post('bform', [BformController::class, 'update'])->name('bform.update');



Route::get('/digital', function () {
    return view('digital');
});
Route::get('/digital',function(){
    return view('digital');
})->name('digital');
Route::get('/gigworkers',function(){
    return view('gigworkers');
})->name('gigworkers');

Route::get('/GenerativeAI',function(){
    return view('GenerativeAI');
})->name('GenerativeAI');

Route::get('/businesses',function(){
    return view('businesses');
})->name('businesses');

Route::get('/careers', function () {
    // Fetch all jobs from the Career model
    $jobs = Career::all();
    
    // Pass the jobs data to the view
    return view('career', compact('jobs'));
});
Route::get('/jobs/apply', [ControllersJobApplicantController::class, 'create'])->name('jobs.apply');
Route::post('/jobs/apply', [ControllersJobApplicantController::class, 'store'])->name('jobs.store');
Route::get('/home', [HomeController::class, 'index'])->name('home');


// Non-authenticated Employer
Route::get('for-businesses',[EmployerHomeController::class,'to_register'])->name('employer.for-businesses');
 Route::post('for-businesses', [EmployerHomeController::class, 'register'])->name('employer.register');
Route::get('business/login', [EmployerHomeController::class, 'to_login'])->name('employer.login');
Route::get('employer/verify-email', [EmployerHomeController::class, 'resendemail'])->name('employer.verify.email')->middleware(['employerAuth']);
Route::post('employer/verify-email', [EmployerHomeController::class, 'brand'])->name('employer.verify.emailr')->middleware(['employerAuth']);
Route::get('employer/brand', [EmployerDashboardController::class, 'brand'])->name('employer.brand')->middleware(['employerAuth', 'empEmail']);
Route::post('employer/brand', [EmployerDashboardController::class, 'savecompany'])->name('employer.save.company')->middleware(['employerAuth', 'empEmail']);
Route::post('business/login', [EmployerHomeController::class, 'login'])->name('employer.login');
Route::get('employer/logout', [EmployerHomeController::class, 'logout'])->name('employer.logout')->middleware(['auth:employer']);

// Truecaller
Route::post('truecaller','TrueCallerController@login')->name('truecaller.login');

//World Controller
Route::post('/getstates','WorldController@states')->name('world.states');
Route::post('getcities','WorldController@cities')->name('world.cities');

// Employer
// Route::middleware(['employerAuth','empEmail','BrandCheck'])->namespace('Employer')->prefix('employer')->name('employer.')->group(function(){
    Route::middleware(['auth:employer'])->prefix('employer')->name('employer.')->group(function () {

    Route::get('dashboard', [EmployerDashboardController::class, 'dashboard'])->name('dashboard');
        Route::controller(EmployerDashboardController::class)->group(function () {
            Route::get('profile', 'profile')->name('profile');
            Route::post('profile', 'update_profile')->name('profile');
            Route::post('profile-image', 'upload_profile_image')->name('profile_image.update');
            Route::get('change-pass', 'change_passr')->name('changepass');
            Route::post('change-pass', 'change_pass')->name('changepass');
        });
    
        Route::controller(EmployerJobController::class)->group(function () {
            Route::get('projects', 'manage')->name('job.manage');
            Route::get('projects/post', 'postr')->name('job.post');
            Route::post('projects/post', 'post')->name('job.post');
            Route::post('projects/post/benefits', 'postbene')->name('job.benefits');
            Route::get('projects/post/confirmation', 'confirmation')->name('job.confirmation');
        
            Route::get('project/edit/{id}', 'editr')->name('job.edit');
            Route::post('project/edit/{id}', 'edit')->name('job.edit');
            Route::get('project/delete/{id}', 'delete')->name('job.delete');
        
            Route::get('project/applications/{id}', 'applications')->name('job.applications');
            Route::get('project/applications/{id}/shortlisteds', 'shortlisteds')->name('job.shortlisteds');
            Route::get('project/applications/{id}/shortlist/{uid}', 'shortlist')->name('job.shortlist');
            Route::post('project/applications/shortlistall', 'shortlistall')->name('job.shortlistall');
        
            Route::get('project/applications/{id}/reject/{uid}', 'reject')->name('job.reject');
            Route::post('project/applications/rejectall', 'rejectall')->name('job.rejectall');
        
            Route::get('project/applications/{id}/select/{uid}', 'select')->name('job.select');
            Route::post('project/applications/selectall', 'selectall')->name('job.selectall');
            Route::get('project/applications/{id}/selecteds', 'selecteds')->name('job.selecteds');
        
            Route::get('project/applications/{jid}/{uid}/issue_certificate', 'issue_certificate')->name('job.issue_certificate');
            Route::post('project/applications/{jid}/payout', 'payout')->name('job.payout');
            Route::get('project/applications/{jid}/{uid}/proofs', 'proofs')->name('job.proofs');
        
            Route::get('project/{id}/download-proofs', 'export_excel')->name('job.eproof');
            Route::get('project/applications/{jid}/{uid}/answers', 'answers')->name('job.answers');
            Route::get('project/{id}/exportapps', 'exportapps')->name('job.exportapps');
            Route::get('project/{id}/exportsl', 'exportsl')->name('job.exportsl');
        });

    
        Route::controller(EmployerGigController::class)->group(function () {
            Route::get('gigs', 'manage')->name('campaign.manage');
            Route::get('gigs/create', 'creater')->name('campaign.create');
            Route::post('gigs/create', 'create')->name('campaign.create');
            Route::get('gigs/edit', 'editer')->name('campaign.editer');
            Route::post('gigs/edit', 'edit')->name('campaign.edit');

            Route::get('gig/{id}/applications', 'applications')->name('gig.applications');
            Route::post('gig/delete', 'delete')->name('gig.delete');
            Route::get('gig/{jid}/applications/{uid}/approve', 'approveApp')->name('campaign.approve');
            Route::get('gig/{jid}/applications/{uid}/unapprove', 'unapproveApp')->name('campaign.unapprove');
            Route::get('gig/{jid}/applications/{uid}/reject', 'rejectApp')->name('campaign.reject');
            Route::get('gig/{jid}/applications/{uid}/view-proof', 'viewproof')->name('campaign.viewproof');
            Route::get('gig/{jid}/applications/{uid}/view-proof/accept', 'acceptproof')->name('campaign.acceptproof');
            Route::get('gig/{jid}/applications/{uid}/view-proof/reject', 'rejectproof')->name('campaign.rejectproof');

            Route::get('gig/{id}/download-proofs', 'export_excel')->name('campaign.eproof');
            Route::get('gig/{id}/download-rejectproofs', 'export_reject_excel')->name('campaign.rejectedproof');
            Route::get('gig/{id}/edit', 'edit')->name('gig.edit');
            Route::post('gig/{id}/editp', 'editp')->name('gig.editp');
            Route::get('gig/{id}/exportapps', 'exportapps')->name('gig.exportapps');

            Route::post('gig/applications/approveAll', 'approveAll')->name('campaign.approveall');
            Route::post('gig/applications/rejectAll', 'rejectAll')->name('campaign.rejectall');
            Route::post('gig/applications/approveAllForRejected', 'approveAllForRejected')->name('campaign.approveallforrejected');
            Route::post('gig/applications/rejectAllForApproved', 'rejectAllForApproved')->name('campaign.rejectallforapproved');
            Route::get('gig/{jid}/applications/{uid}/viewedproof', 'viewproof_after_reject_accept')->name('campaign.viewedproof');
        });
    // Campaigns
    Route::controller(EmployerCampaignController::class)->group(function () {
        Route::get('campaigns', 'index')->name('missions');
        Route::post('campaign/delete', 'delete')->name('mission.delete');
        Route::get('campaign/applications/{id}', 'applications')->name('mission.applications');
        Route::get('campaign/applications/accept/{id}', 'accept')->name('mission.accept');
        Route::get('campaign/applications/reject/{id}', 'reject')->name('mission.reject');
        Route::get('campaign/response/{id}', 'response')->name('mission.response');
        Route::post('campaign/response/accept', 'acceptResp')->name('mission.acceptResp');
        Route::post('campaign/response/reject', 'rejectResp')->name('mission.rejectResp');
    });
});
Route::get('employer/email-not-verified',function(){
    return view('employer.pages.text_email_verify');
})->name('employer.email.verify');

Route::get('projects', [ProjectController::class, 'list'])->name('projects');
Route::get('project/{id}', [ProjectController::class, 'details'])->name('job.details');
Route::post('project/apply', [ProjectController::class, 'apply'])->name('job.apply');
Route::post('project/location', [ProjectController::class, 'loc'])->name('job.location');
Route::post('project/category', [ProjectController::class, 'cat'])->name('job.cat');
Route::post('project/proof', [ProjectController::class, 'proofs'])->name('job.proof');

// Gigs
Route::get('gigs', [GigController::class, 'list'])->name('gigs');
Route::get('gig/details/{id}', [GigController::class, 'details'])->name('campaign.details');
Route::post('gig/details/apply', [GigController::class, 'apply'])->name('campaign.apply');
Route::get('gigs/cat/{id}', [GigController::class, 'cats'])->name('campaign.cat');

// Gig proofs
Route::post('gig/proof/fb', [GigController::class, 'prooffb'])->name('campaign.prooffb');
Route::post('gig/proof/wa', [GigController::class, 'proofwa'])->name('campaign.proofwa');
Route::post('gig/proof/insta', [GigController::class, 'proofinsta'])->name('campaign.proofinsta');
Route::post('gig/proof/yt', [GigController::class, 'proofyt'])->name('campaign.proofyt');
Route::post('gig/proof/instap', [GigController::class, 'proofinstap'])->name('campaign.proofinstap');
Route::post('gig/proof/os', [GigController::class, 'proofos'])->name('campaign.proofos');
Route::post('gig/proof/ar', [GigController::class, 'proofar'])->name('campaign.proofar');
Route::post('gig/proof/ls', [GigController::class, 'proofls'])->name('campaign.proofls');



// Campaigns
Route::get('campaigns', [CampaignController::class, 'list'])->name('campaigns');
Route::get('campaign/details/{id}', [CampaignController::class, 'details'])->name('mission.details');
Route::post('campaign/apply', [CampaignController::class, 'apply'])->name('mission.apply')->middleware('auth', 'verified');
Route::post('campaign/submit-response', [CampaignController::class, 'responser'])->name('campaign.responser')->middleware('auth', 'verified');
Route::get('campaign/submit-responsea/{id}/{uid}', [CampaignController::class, 'responsera'])->name('campaign.responsera');
Route::post('campaign/submit/{id}/{cid}', [CampaignController::class, 'response'])->name('campaign.response')->middleware('auth', 'verified');

// Users
Route::get('user/mobile-not-verified', [UserDashboardController::class, 'mobileNotVerified'])->name('user.mobile-not-ver')->middleware(['auth', 'verified']);
Route::get('user/verify-mobile', [UserDashboardController::class, 'verifyMobiler'])->name('user.verify-mobile')->middleware(['auth', 'verified']);
Route::post('user/verify-mobile', [UserDashboardController::class, 'verifyMobile'])->name('user.verify-mobilep')->middleware(['auth', 'verified']);

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('app-download', [UserDashboardController::class, 'download'])->name('download_app');
    Route::get('dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('resume', [UserDashboardController::class, 'resume'])->name('resume');
    Route::post('edu-update', [UserDashboardController::class, 'eduUpdate'])->name('edu-update');
    Route::post('exp-update', [UserDashboardController::class, 'expUpdate'])->name('exp-update');
    Route::post('proj-update', [UserDashboardController::class, 'projUpdate'])->name('proj-update');
    Route::post('skill-update', [UserDashboardController::class, 'skillUpdate'])->name('skill-update');
    Route::post('hobby-update', [UserDashboardController::class, 'hobbyUpdate'])->name('hobby-update');
    Route::post('ach-update', [UserDashboardController::class, 'achUpdate'])->name('ach-update');
    Route::post('social-update', [UserDashboardController::class, 'socialUpdate'])->name('social-update');
    Route::get('edu-delete/{id}', [UserDashboardController::class, 'eduDelete'])->name('edu-delete');
    Route::get('exp-delete/{id}', [UserDashboardController::class, 'expDelete'])->name('exp-delete');
    Route::get('proj-delete/{id}', [UserDashboardController::class, 'projDelete'])->name('proj-delete');
    Route::get('skill-delete/{id}', [UserDashboardController::class, 'skillDelete'])->name('skill-delete');
    Route::get('profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('profile', [UserDashboardController::class, 'updateProfile'])->name('profile');
    Route::get('change-pass', [UserDashboardController::class, 'changepwr'])->name('changePassword');
    Route::post('change-pass', [UserDashboardController::class, 'updatePassword'])->name('changePassword');

    // Withdraw
    Route::get('withdraw', [UserDashboardController::class, 'ShowWithdrawMethod'])->name('withdraw');
    Route::get('withdraw-log', [UserDashboardController::class, 'ShowWithdrawLog'])->name('show_withdraw_log');
    Route::post('withdraw-preview', [UserDashboardController::class, 'WithdrawPreview'])->name('withdraw_preview');
    Route::post('withdraw-confirm', [UserDashboardController::class, 'WithdrawConfirm'])->name('withdraw_confirm');
    Route::get('logout', [UserDashboardController::class, 'logout'])->name('logout');

    Route::get('projects', [UserDashboardController::class, 'projects'])->name('projects.show');
    Route::get('gigs', [UserDashboardController::class, 'gigs'])->name('gigs.show');
    Route::get('campaigns', [UserDashboardController::class, 'campaigns'])->name('campaigns.show');
});

/// User Routes
Route::post('acc_details', [RazorpayController::class, 'create_contact']);
Route::get('users/{id}', [ApplicantController::class, 'index'])->name('applicant.view');
Route::get('users/{id}/print-resume', [ApplicantController::class, 'printv'])->name('print.view');
Route::get('users/{id}/print-pdf', [ApplicantController::class, 'print'])->name('print.pdf');

// Certificate Controller
Route::get('certificate/{jid}/user/{uid}/view', [ApplicantController::class, 'printc'])->name('certificate.print');

// Manager Routes
Route::get('manager/users/export/excel', [MemberManageController::class, 'excel_export'])->name('manager.member.export');
Route::get('manager/users/export/excel/ref', [MemberManageController::class, 'excel_referrals'])->name('manager.member.export.referrals');
Route::get('manager/login', [ManagerHomeController::class, 'loginr'])->name('manager.loginr');
Route::post('manager/login', [ManagerHomeController::class, 'login'])->name('manager.login');

Route::middleware(['Manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
        Route::get('pending-projects', [MainController::class, 'pendingjobs'])->name('pendingjobs');
        Route::get('all-projects', [MainController::class, 'jobAll'])->name('jobs.all');
        Route::post('pending-projects/approve', [MainController::class, 'jobApprove'])->name('job.approve');
        Route::post('pending-projects/reject', [MainController::class, 'jobReject'])->name('job.delete');
        Route::get('pending-gigs', [MainController::class, 'pendingGigs'])->name('gigs.pending');
        Route::get('all-gigs', [MainController::class, 'allGigs'])->name('gigs.all');
        Route::get('create-gigs', [MainController::class, 'createGig'])->name('gigs.create');
        Route::post('create-gigs', [MainController::class, 'storeGig'])->name('gig.create');
        Route::get('approve-campaign/{id}', [MainController::class, 'approveCampaign'])->name('campaign.approve');
        Route::get('reject-campaign/{id}', [MainController::class, 'rejectCampaign'])->name('campaign.reject');

        // Campaigns
        Route::get('campaigns', [ManagerCampaignController::class, 'index'])->name('missions');
        Route::get('campaign/create', [ManagerCampaignController::class, 'creater'])->name('mission.create');
        Route::post('campaign/create', [ManagerCampaignController::class, 'create'])->name('mission.create');
        Route::post('storeForm', [ManagerCampaignController::class, 'storeForm'])->name('mission.storeForm');
        Route::post('campaign/delete', [ManagerCampaignController::class, 'delete'])->name('mission.delete');
        Route::get('campaign/applications/{id}', [ManagerCampaignController::class, 'applications'])->name('mission.applications');
        Route::get('campaign/applications/accept/{id}', [ManagerCampaignController::class, 'accept'])->name('mission.accept');
        Route::get('campaign/applications/reject/{id}', [ManagerCampaignController::class, 'reject'])->name('mission.reject');
        Route::get('campaign/response/{id}', [ManagerCampaignController::class, 'response'])->name('mission.response');
        Route::post('campaign/response/accept', [ManagerCampaignController::class, 'acceptResp'])->name('mission.acceptResp');
        Route::post('campaign/response/reject', [ManagerCampaignController::class, 'rejectResp'])->name('mission.rejectResp');

        // Employers
        Route::get('employers', [ManagerEmployerController::class, 'index'])->name('employers');
        Route::post('employer/login', [ManagerEmployerController::class, 'login'])->name('employer.login');

        // Telecallings
        Route::get('telecallings', [ManagerTelecallingController::class, 'index'])->name('telecallings');
        Route::get('telecallings/create', [ManagerTelecallingController::class, 'create'])->name('telecalling.create');
        Route::post('telecallings/create', [ManagerTelecallingController::class, 'createPost'])->name('telecalling.create');
        Route::post('telecallings/delete', [ManagerTelecallingController::class, 'delete'])->name('telecalling.delete');
        Route::get('telecalling/applications/{id}', [ManagerTelecallingController::class, 'applications'])->name('telecalling.applications');
        Route::post('telecalling/distribute', [ManagerTelecallingController::class, 'distribute'])->name('telecalling.distribute');
        Route::post('telecalling/application/select', [ManagerTelecallingController::class, 'select'])->name('telecalling.select');
        Route::post('telecalling/application/reject', [ManagerTelecallingController::class, 'reject'])->name('telecalling.reject');
        Route::get('telecalling/application/view-data/{tid}/{uid}', [ManagerTelecallingController::class, 'viewData'])->name('telecalling.viewdata');
        Route::get('telecalling/application/view-feedback/{id}', [ManagerTelecallingController::class, 'feedback'])->name('telecalling.feedback');

        Route::get('logout', [ManagerHomeController::class, 'logout'])->name('logout');
    });

// Test Routes
Route::get('/acc_details', [RazorpayController::class, 'create_contact']);
Route::post('/acc_details', [RazorpayController::class, 'add_contact']);
Route::get('/givereward/{id}/{amt}', [RazorpayController::class, 'givereward']);

// Email Routes
Route::get('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');
Route::get('/send-simple-email', [EmailController::class, 'sendSimpleEmail'])->name('send.simple.email');
