<?php

use Dwij\Laraadmin\Helpers\LAHelper;
use Illuminate\Http\Request;

/* ================== Homepage ================== */
Route::get('/admin', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(LAHelper::laravel_ver() == 5.3 || LAHelper::laravel_ver() == 5.4) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\UsersController@change_password');
	
	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');
	
	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');


    /* ================== Accessories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/accessories', 'LA\AccessoriesController');
    Route::get(config('laraadmin.adminRoute') . '/accessory_dt_ajax', 'LA\AccessoriesController@dtajax');
    Route::post(config('laraadmin.adminRoute') . '/accessories_by_resourceid', 'LA\AccessoriesController@accessories_by_resourceid');

    /* ================== Resources ================== */
    Route::resource(config('laraadmin.adminRoute') . '/resources', 'LA\ResourcesController');
	Route::get(config('laraadmin.adminRoute') . '/resource_dt_ajax', 'LA\ResourcesController@dtajax');
	
	Route::get(config('laraadmin.adminRoute') . '/schedule', 'ScheduleController@index');
	Route::post(config('laraadmin.adminRoute') . '/getResource', 'LA\ResourcesController@getResource');

    /* ================== Start_Ons ================== */
    Route::resource(config('laraadmin.adminRoute') . '/start_ons', 'LA\Start_OnsController');
    Route::get(config('laraadmin.adminRoute') . '/start_on_dt_ajax', 'LA\Start_OnsController@dtajax');



    /* ================== All_Schedules ================== */
    Route::resource(config('laraadmin.adminRoute') . '/all_schedules', 'LA\All_SchedulesController');
	Route::get(config('laraadmin.adminRoute') . '/all_schedule_dt_ajax', 'LA\All_SchedulesController@dtajax');
	
	/* ================== Time layout for all days viewing ================== */
	Route::post(config('laraadmin.adminRoute') . '/store_data', 'LA\StoreDataController@store');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_0', 'LA\StoreDataController@store_0');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_1', 'LA\StoreDataController@store_1');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_2', 'LA\StoreDataController@store_2');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_3', 'LA\StoreDataController@store_3');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_4', 'LA\StoreDataController@store_4');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_f', 'LA\StoreDataController@store_f');
	// Route::get(config('laraadmin.adminRoute') . '/store_data_6', 'LA\StoreDataController@store_6');
	Route::post(config('laraadmin.adminRoute') . '/store_data_num', 'LA\StoreDataController@store_data_num');
	Route::post(config('laraadmin.adminRoute') . '/save', 'LA\StoreDataController@save');
	Route::post(config('laraadmin.adminRoute') . '/save_0', 'LA\StoreDataController@save_0');
	

    /* ================== Reservations ================== */
    Route::resource(config('laraadmin.adminRoute') . '/reservations', 'LA\ReservationsController');
    Route::get(config('laraadmin.adminRoute') . '/reservation_dt_ajax', 'LA\ReservationsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/getstartendtime', 'LA\ReservationsController@getstartendtime');
	Route::post(config('laraadmin.adminRoute') . '/getdatetime', 'LA\ReservationsController@getdatetime');
	Route::post(config('laraadmin.adminRoute') . '/reservations/next', 'LA\ReservationsController@next');
	Route::post(config('laraadmin.adminRoute') . '/reservations/previous', 'LA\ReservationsController@previous');
	Route::post(config('laraadmin.adminRoute') . '/cancel', 'LA\ReservationsController@cancel');
	
	Route::post(config('laraadmin.adminRoute') . '/getimageid', 'LA\ReservationsController@getimageid');
    /* ================== Reservations_users ================== */
    Route::resource(config('laraadmin.adminRoute') . '/reservations_users', 'LA\Reservations_usersController');
    Route::get(config('laraadmin.adminRoute') . '/reservations_user_dt_ajax', 'LA\Reservations_usersController@dtajax');
    Route::post(config('laraadmin.adminRoute') . '/getParticipants', 'LA\Reservations_usersController@getParticipants');

    /* ================== Reservations_invitees ================== */
    Route::resource(config('laraadmin.adminRoute') . '/reservations_invitees', 'LA\Reservations_inviteesController');
    Route::get(config('laraadmin.adminRoute') . '/reservations_invitee_dt_ajax', 'LA\Reservations_inviteesController@dtajax');
    Route::post(config('laraadmin.adminRoute') . '/getInvitees', 'LA\Reservations_inviteesController@getInvitees');

    /* ================== Reservation_accessories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/reservation_accessories', 'LA\Reservation_accessoriesController');
	Route::get(config('laraadmin.adminRoute') . '/reservation_accessory_dt_ajax', 'LA\Reservation_accessoriesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/getAccessories', 'LA\Reservation_accessoriesController@getAccessories');
	
	/* ================== Calendar ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendar', 'CalendarController');

	/* ================== Reserve ================== */
	Route::post(config('laraadmin.adminRoute') . '/reserve', 'ReserveController@index');
	Route::post(config('laraadmin.adminRoute') . '/reserve_next', 'ReserveController@next');
	
	/* ================== BookingList ================== */
	Route::resource(config('laraadmin.adminRoute') . '/bookinglist', 'BookinglistController');
	Route::match(['get', 'post'], config('laraadmin.adminRoute') . '/bookinglist', 'BookinglistController@bookinglist_filter');
	Route::get(config('laraadmin.adminRoute') .'/bookinglist/{id}/cancel', 'BookinglistController@destroy');
	

    /* ================== Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/groups', 'LA\GroupsController');
    Route::get(config('laraadmin.adminRoute') . '/group_dt_ajax', 'LA\GroupsController@dtajax');


    /* ================== User_Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/user_groups', 'LA\User_GroupsController');
    Route::resource(config('laraadmin.adminRoute') . '/user_groups', 'LA\User_GroupsController@destroy');
    Route::get(config('laraadmin.adminRoute') . '/user_group_dt_ajax', 'LA\User_GroupsController@dtajax');

    /* ================== Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/groups', 'LA\GroupsController');
    Route::get(config('laraadmin.adminRoute') . '/group_dt_ajax', 'LA\GroupsController@dtajax');

    /* ================== User_Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/user_groups', 'LA\User_GroupsController');
    Route::get(config('laraadmin.adminRoute') . '/user_group_dt_ajax', 'LA\User_GroupsController@dtajax');

    /* ================== Resource_types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/resource_types', 'LA\Resource_typesController');
    Route::get(config('laraadmin.adminRoute') . '/resource_type_dt_ajax', 'LA\Resource_typesController@dtajax');

    /* ================== Resource_Users ================== */
    Route::resource(config('laraadmin.adminRoute') . '/resource_users', 'LA\Resource_UsersController');
    Route::get(config('laraadmin.adminRoute') . '/resource_user_dt_ajax', 'LA\Resource_UsersController@dtajax');

    /* ================== Resource_Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/resource_groups', 'LA\Resource_GroupsController');
    Route::get(config('laraadmin.adminRoute') . '/resource_group_dt_ajax', 'LA\Resource_GroupsController@dtajax');


    /* ================== Car_Requests ================== */
	Route::resource(config('laraadmin.adminRoute') . '/car_requests', 'LA\Car_RequestsController');
	Route::get(config('laraadmin.adminRoute') .'/car_requests/{id}/edit', 'LA\Car_RequestsController@edit');
	Route::get(config('laraadmin.adminRoute') .'/car_requests/{id}/cancel', 'LA\Car_RequestsController@destroy');
	Route::get(config('laraadmin.adminRoute') . '/car_request_dt_ajax', 'LA\Car_RequestsController@dtajax');

	
	/* ================== CarRequestsApprove ================== */
	Route::resource(config('laraadmin.adminRoute') . '/carrequestsapprove', 'CarRequests_approveController');
	Route::get(config('laraadmin.adminRoute') .'/carrequestsapproveindex', 'CarRequests_approveController@index');
	Route::post(config('laraadmin.adminRoute') .'/carrequestsapprove', 'CarRequests_approveController@confirm');
	Route::post(config('laraadmin.adminRoute') .'/carrequestspending', 'CarRequests_approveController@pending');
	Route::post(config('laraadmin.adminRoute') .'/carrequestsreject', 'CarRequests_approveController@reject');
	Route::post(config('laraadmin.adminRoute') .'/carrequestscancel', 'CarRequests_approveController@cancel');
	Route::match(['get', 'post'], config('laraadmin.adminRoute') . '/carrequestslist_filter', 'CarRequests_approveController@list_filter');

    /* ================== Car_Request_Statuses ================== */
    Route::resource(config('laraadmin.adminRoute') . '/car_request_statuses', 'LA\Car_Request_StatusesController');
    Route::get(config('laraadmin.adminRoute') . '/car_request_status_dt_ajax', 'LA\Car_Request_StatusesController@dtajax');
	
    /* ================== Room_Types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/room_types', 'LA\Room_TypesController');
    Route::get(config('laraadmin.adminRoute') . '/room_type_dt_ajax', 'LA\Room_TypesController@dtajax');

    /* ================== Reports ================== */
	Route::resource(config('laraadmin.adminRoute') . '/bookingreports', 'ReportsController');
	Route::match(['get', 'post'], config('laraadmin.adminRoute') . '/bookingreports', 'ReportsController@bookingreport_filter');
	Route::match(['get', 'post'], config('laraadmin.adminRoute') . '/carrequestedreports', 'ReportsController@carrequestedreport_filter');


    /* ================== Reservation_statuses ================== */
    Route::resource(config('laraadmin.adminRoute') . '/reservation_statuses', 'LA\Reservation_statusesController');
	Route::post(config('laraadmin.adminRoute') .'/reservation_approve', 'LA\Reservation_statusesController@confirm');
    Route::get(config('laraadmin.adminRoute') . '/reservation_status_dt_ajax', 'LA\Reservation_statusesController@dtajax');


    /* ================== Car_Setups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/car_setups', 'LA\Car_SetupsController');
    Route::get(config('laraadmin.adminRoute') . '/car_setup_dt_ajax', 'LA\Car_SetupsController@dtajax');
});
