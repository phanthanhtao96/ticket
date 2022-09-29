<?php

use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChangesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DutyListsController;
use App\Http\Controllers\EmailTemplatesController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PrioritiesController;
use App\Http\Controllers\ProblemsController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\SolutionsController;
use App\Http\Controllers\UsersController;

use Illuminate\Support\Facades\Route;

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


Route::get('login', [UsersController::class, 'getLogin'])->name('login');
Route::post('login', [UsersController::class, 'postLogin'])->name('login');

Route::get('ms-login', [UsersController::class, 'msLogin'])->name('ms-login');
Route::get('ms-login-redirect', [UsersController::class, 'msLoginRedirect'])->name('ms-login-redirect');

Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [UsersController::class, 'getLogout']);
    Route::get('/', [DashboardController::class, 'getDashboard']);
    Route::get('access-denied', [Controller::class, 'getAccessDenied']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('list/{filter?}/{filter_value?}', [UsersController::class, 'getUsers'])->middleware('role:view-user');
        Route::post('list', [UsersController::class, 'postUsers'])->middleware('role:view-user');
        Route::get('user/{id}', [UsersController::class, 'getUser'])->middleware('role:edit-user');
        Route::post('user', [UsersController::class, 'postUser'])->middleware('role:edit-user');
        Route::get('list-json/{company_id}/{group_id}', [UsersController::class, 'getUsersJson']);
        Route::get('user-json/{id}', [UsersController::class, 'getUserJson']);
        Route::get('search/{keyword?}', [UsersController::class, 'searchUsersJson']);
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::get('list/{filter?}/{filter_value?}', [ClientsController::class, 'getClients'])->middleware('role:view-customer');
        Route::post('list', [ClientsController::class, 'postClients'])->middleware('role:view-customer');
        Route::get('customer/{id}', [ClientsController::class, 'getClient'])->middleware('role:edit-customer');
        Route::post('customer', [ClientsController::class, 'postClient'])->middleware('role:edit-customer');
        Route::get('search/{keyword?}', [ClientsController::class, 'searchClientsJson']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('list', [RolesController::class, 'getRoles']);
        Route::get('role/{id}', [RolesController::class, 'getRole']);
        Route::post('role', [RolesController::class, 'postRole']);
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('list', [CompaniesController::class, 'getCompanies'])->middleware('role:view-company');
        Route::get('company/{id}', [CompaniesController::class, 'getCompany'])->middleware('role:view-company');
        Route::post('company', [CompaniesController::class, 'postCompany'])->middleware('role:edit-company');
        Route::get('del/{id}', [CompaniesController::class, 'delCompany'])->middleware('role:delete-company');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('list', [GroupsController::class, 'getGroups'])->middleware('role:view-group');
        Route::get('group/{id}', [GroupsController::class, 'getGroup'])->middleware('role:edit-group');
        Route::post('group', [GroupsController::class, 'postGroup'])->middleware('role:edit-group');
    });

    Route::group(['prefix' => 'requests'], function () {
        Route::get('list/{filter?}/{filter_value?}/{status?}', [RequestsController::class, 'getRequests'])->middleware('role:view-request');
        Route::post('list', [RequestsController::class, 'postRequests'])->middleware('role:view-request');

        Route::get('undefined-list', [RequestsController::class, 'getUndefinedList'])->middleware('role:view-request');

        Route::get('request/{id}/{option?}', [RequestsController::class, 'getRequest'])->middleware('role:edit-request');
        Route::post('request', [RequestsController::class, 'postRequest'])->middleware('role:edit-request');
        Route::post('add-solutions', [RequestsController::class, 'addSolutions']);
        Route::post('remove-solution', [RequestsController::class, 'removeSolution']);
        Route::get('search/{keyword?}', [RequestsController::class, 'searchRequestsJson']);
        Route::get('download-attachment/{id}/{attachment_id}', [RequestsController::class, 'downloadAttachment']);
    });

    Route::group(['prefix' => 'problems'], function () {
        Route::get('list/{filter?}/{filter_value?}/{status?}', [ProblemsController::class, 'getProblems'])->middleware('role:view-problem');
        Route::post('list', [ProblemsController::class, 'postProblems'])->middleware('role:view-problem');
        Route::get('problem/{id}/{option?}', [ProblemsController::class, 'getProblem'])->middleware('role:edit-problem');
        Route::post('problem', [ProblemsController::class, 'postProblem'])->middleware('role:edit-problem');
        Route::post('add-requests', [ProblemsController::class, 'addRequests']);
        Route::post('remove-request', [ProblemsController::class, 'removeRequest']);
        Route::post('add-solutions', [ProblemsController::class, 'addSolutions']);
        Route::post('remove-solution', [ProblemsController::class, 'removeSolution']);
    });

    Route::group(['prefix' => 'solutions'], function () {
        Route::get('list/{filter?}/{filter_value?}', [SolutionsController::class, 'getSolutions'])->middleware('role:view-solution');
        Route::post('list', [SolutionsController::class, 'postSolutions'])->middleware('role:view-solution');
        Route::get('solution/{id}/{option?}', [SolutionsController::class, 'getSolution'])->middleware('role:view-solution');
        Route::post('solution', [SolutionsController::class, 'postSolution'])->middleware('role:edit-solution');
        Route::get('search/{keyword?}', [SolutionsController::class, 'searchSolutionsJson']);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('list', [CategoriesController::class, 'getCategories'])->middleware('role:view-category');
        Route::get('category/{id}', [CategoriesController::class, 'getCategory'])->middleware('role:edit-category');
        Route::post('category', [CategoriesController::class, 'postCategory'])->middleware('role:edit-category');
        Route::get('del/{id?}', [CategoriesController::class, 'delCategory'])->middleware('role:delete-category');
    });

    Route::group(['prefix' => 'sla'], function () {
        Route::get('list', [SLAController::class, 'getSLAList'])->middleware('role:view-sla');
        Route::get('edit/{id}/{option?}', [SLAController::class, 'getSLA'])->middleware('role:edit-sla');
        Route::post('edit', [SLAController::class, 'postSLA'])->middleware('role:edit-sla');
        Route::post('update-rule', [SLAController::class, 'updateRule'])->middleware('role:edit-sla');
        Route::get('get-rules-json/{id}/{column}', [SLAController::class, 'getDataRules'])->middleware('role:view-sla');
        Route::get('get-rule-json/{id}/{column}/{rule_id}', [SLAController::class, 'getRule'])->middleware('role:view-sla');
        Route::get('del-rule/{id}/{column}/{rule_id}', [SLAController::class, 'deleteRule'])->middleware('role:edit-sla');
    });

    Route::group(['prefix' => 'priorities'], function () {
        Route::get('list', [PrioritiesController::class, 'getPriorities'])->middleware('role:view-priority');
        Route::get('priority/{id}', [PrioritiesController::class, 'getPriority'])->middleware('role:view-priority');
        Route::post('priority', [PrioritiesController::class, 'postPriority'])->middleware('role:edit-priority');
    });

    Route::group(['prefix' => 'imgs'], function () {
        Route::get('{select?}', [ImagesController::class, 'getImages']);
        Route::post('/', [ImagesController::class, 'postImage'])->middleware('role:upload');
    });

    Route::group(['prefix' => 'replies'], function () {
        Route::get('{type}/{id}', [RepliesController::class, 'getRepliesJson']);
        Route::post('', [RepliesController::class, 'postReply'])->middleware('role:reply-request');
    });

    Route::group(['prefix' => 'changes'], function () {
        Route::get('list', [ChangesController::class, 'getChanges'])->middleware('role:view-changes');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('', [ReportsController::class, 'getReport'])->middleware('role:view-report');
        Route::post('', [ReportsController::class, 'runReport'])->middleware('role:view-report');
        Route::post('export', [ReportsController::class, 'export'])->middleware('role:view-report');
    });

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('new-json', [NotificationsController::class, 'getNewNotificationsJson']);
        Route::post('received', [NotificationsController::class, 'receivedNotification']);
        Route::get('mark-as-read', [NotificationsController::class, 'markAsRead']);

    });

    Route::group(['prefix' => 'emails'], function () {
        Route::get('sent-list', [MailController::class, 'getEmailSentList'])->middleware('role:view-email-history');
        Route::get('email/{id}', [MailController::class, 'getEmail'])->middleware('role:view-email-history');
    });

    Route::group(['prefix' => 'email-templates'], function () {
        Route::get('list', [EmailTemplatesController::class, 'getEmailTemplates']);
        Route::get('email-template/{id}', [EmailTemplatesController::class, 'getEmailTemplate'])->middleware('role:view-email-template');
        Route::post('email-template', [EmailTemplatesController::class, 'postEmailTemplate'])->middleware('role:edit-email-template');
    });

    Route::group(['prefix' => 'attachments'], function () {
        Route::post('upload', [AttachmentsController::class, 'postAttachment'])->middleware('role:upload');
    });

    Route::group(['prefix' => 'configurations'], function () {
        Route::get('', [ConfigurationsController::class, 'getDefaultConfigurations']);
        Route::post('', [ConfigurationsController::class, 'postDefaultConfigurations']);
        Route::get('report', [ConfigurationsController::class, 'getReportConfigurations']);
        Route::post('report', [ConfigurationsController::class, 'postReportConfigurations']);
        Route::post('test-report', [ConfigurationsController::class, 'testReportConfigurations']);
    });

    Route::group(['prefix' => 'duty-list'], function () {
        Route::get('', [DutyListsController::class, 'getDutyList']);
        Route::post('', [DutyListsController::class, 'postDutyList']);
    });
});

Route::group(['prefix' => 'rating'], function () {
    Route::get('{id}/{email}', [RatingsController::class, 'getGuestRating']);
    Route::post('', [RatingsController::class, 'postGuestRating']);
});
