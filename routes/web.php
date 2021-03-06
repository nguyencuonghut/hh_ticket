<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');
Route::group(['middleware' => ['auth']], function () {
    
    /**
     * Main
     */
        Route::get('/', 'PagesController@dashboard');
        Route::get('dashboard', 'PagesController@dashboard')->name('dashboard');
        Route::post('/ticketstatisticfiltered', 'TicketsController@ticketStatisticFiltered')->name('tickets.ticketstatisticfiltered');
    /**
     * Users
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/data', 'UsersController@anyData')->name('users.data');
        Route::get('/taskdata/{id}', 'UsersController@taskData')->name('users.taskdata');
        Route::get('/leaddata/{id}', 'UsersController@leadData')->name('users.leaddata');
        Route::get('/clientdata/{id}', 'UsersController@clientData')->name('users.clientdata');
        Route::get('/users', 'UsersController@users')->name('users.users');
    });
        Route::resource('users', 'UsersController');

    /**
     * Tickets
     */
    Route::group(['prefix' => 'tickets'], function () {
        Route::patch('tickets/directorconfirm/{id}', 'TicketsController@directorConfirm')->name('directorConfirm');
        Route::patch('tickets/setresponsibility/{id}', 'TicketsController@setResponsibility')->name('setResponsibility');
        Route::patch('tickets/evaluate/{id}', 'TicketsController@evaluateTicket')->name('evaluateTicket');
        Route::patch('tickets/updaterootcause/{id}', 'TicketsController@updateRootCause')->name('updateRootCause');
        Route::patch('tickets/rootcauseapprove/{id}', 'TicketsController@rootCauseApprove')->name('rootCauseApprove');
        Route::patch('tickets/asseteffectiveneess/{id}', 'TicketsController@assetEffectiveness')->name('assetEffectiveness');
        Route::get('tickets/data', 'TicketsController@anyData')->name('tickets.data');
        Route::patch('assigntroubleshooter/{id}', 'TicketsController@assignTroubleshooter')->name('assignTroubleshooter');
        Route::patch('requesttoapprovetroublehoot/{id}', 'TicketsController@requestToApproveTroubleshoot')->name('requestToApproveTroubleshoot');
        Route::patch('approvetroubleshoot/{id}', 'TicketsController@approveTroubleshoot')->name('approveTroubleshoot');
        Route::patch('assignpreventer/{id}', 'TicketsController@assignPreventer')->name('assignPreventer');
        Route::patch('requesttoapproveprevention/{id}', 'TicketsController@requestToApprovePrevention')->name('requestToApprovePrevention');
        Route::patch('approveprevention/{id}', 'TicketsController@approvePrevention')->name('approvePrevention');
        Route::get('tickets/mycreateddata', 'TicketsController@myCreatedData')->name('tickets.mycreateddata');
        Route::get('tickets/myconfirmeddata', 'TicketsController@myConfirmedData')->name('tickets.myconfirmeddata');
        Route::patch('tickets/markticketcompleted/{id}', 'TicketsController@markTicketCompleted')->name('markTicketCompleted');
    });
    Route::resource('tickets', 'TicketsController');

    /**
     * Troubleshoots
     */
    Route::group(['prefix' => 'troubleshoots'], function () {
    });
    Route::patch('troubleshoots/markcomplete/{id}', 'TroubleshootsController@markComplete')->name('troubleshootMarkComplete');
    Route::patch('troubleshoots/updateassign/{id}', 'TroubleshootsController@updateAssign')->name('troubleshootUpdateAssign');
    Route::post('troubleshoots/{id}/store',
        ['as' => 'troubleshoots.store', 'uses' => 'TroubleshootsController@store']);
    Route::get('troubleshoots/myactionsdata', 'TroubleshootsController@myActionsData')->name('troubleshoots.myactionsdata');
    Route::resource('troubleshoots', 'TroubleshootsController', ['except' => ['store'] ]);

    /**
     * Preventions
     */
    Route::group(['prefix' => 'preventions'], function () {
    });
    Route::patch('preventions/markcomplete/{id}', 'PreventionsController@markComplete')->name('preventionMarkComplete');
    Route::patch('preventions/updateassign/{id}', 'PreventionsController@updateAssign')->name('preventionUpdateAssign');
    Route::post('preventions/{id}/store',
        ['as' => 'preventions.store', 'uses' => 'PreventionsController@store']);
    Route::get('preventions/myactionsdata', 'PreventionsController@myActionsData')->name('preventions.myactionsdata');
    Route::resource('preventions', 'PreventionsController', ['except' => ['store'] ]);

	 /**
     * Roles
     */
        Route::resource('roles', 'RolesController');
    /**
     * Clients
     */
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/data', 'ClientsController@anyData')->name('clients.data');
        Route::post('/create/cvrapi', 'ClientsController@cvrapiStart');
        Route::post('/upload/{id}', 'DocumentsController@upload');
        Route::patch('/updateassign/{id}', 'ClientsController@updateAssign');
    });
        Route::resource('clients', 'ClientsController');
	    Route::resource('documents', 'DocumentsController');
	
      
    /**
     * Tasks
     */
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/data', 'TasksController@anyData')->name('tasks.data');
        Route::patch('/updatestatus/{id}', 'TasksController@updateStatus');
        Route::patch('/updateassign/{id}', 'TasksController@updateAssign');
        Route::post('/updatetime/{id}', 'TasksController@updateTime');
    });
        Route::resource('tasks', 'TasksController');

    /**
     * Leads
     */
    Route::group(['prefix' => 'leads'], function () {
        Route::get('/data', 'LeadsController@anyData')->name('leads.data');
        Route::patch('/updateassign/{id}', 'LeadsController@updateAssign');
        Route::patch('/updatestatus/{id}', 'LeadsController@updateStatus');
        Route::patch('/updatefollowup/{id}', 'LeadsController@updateFollowup')->name('leads.followup');
    });
        Route::resource('leads', 'LeadsController');
        Route::post('/comments/{type}/{id}', 'CommentController@store');
    /**
     * Settings
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/permissionsUpdate', 'SettingsController@permissionsUpdate');
        Route::patch('/overall', 'SettingsController@updateOverall');
    });

    /**
     * Departments
     */
        Route::resource('departments', 'DepartmentsController'); 

    /**
     * Integrations
     */
    Route::group(['prefix' => 'integrations'], function () {
        Route::get('Integration/slack', 'IntegrationsController@slack');
    });
        Route::resource('integrations', 'IntegrationsController');

    /**
     * Notifications
     */
    Route::group(['prefix' => 'notifications'], function () {
        Route::post('/markread', 'NotificationsController@markRead')->name('notification.read');
        Route::get('/markall', 'NotificationsController@markAll');
        Route::get('/{id}', 'NotificationsController@markRead');
    });

    /**
     * Invoices
     */
    Route::group(['prefix' => 'invoices'], function () {
        Route::post('/updatepayment/{id}', 'InvoicesController@updatePayment')->name('invoice.payment.date');
        Route::post('/reopenpayment/{id}', 'InvoicesController@reopenPayment')->name('invoice.payment.reopen');
        Route::post('/sentinvoice/{id}', 'InvoicesController@updateSentStatus')->name('invoice.sent');
        Route::post('/newitem/{id}', 'InvoicesController@newItem')->name('invoice.new.item');
    });
        Route::resource('invoices', 'InvoicesController');
});
