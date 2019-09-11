<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

//Registration
Route::get('/register', function(){return view('registration.create');});
Route::post('register', 'Auth\RegisterController@store')->name('auth.register');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

// Route::group(['middleware' => ['auth'], 'prefix' => 'patient', 'as' => 'patient.'], function(){
//     Route::get('/home', 'HomeController@index');

//     Route::get('patients_get_info/{id}', ['uses' => 'Admin\PatientController@show', 'as' => 'patients.get_info']);
//     // Route::post();
//     // Route::put();
// });

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    
    Route::resource('users', 'Admin\UsersController');    
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::put('users_restore/{id}', ['uses' => 'Admin\UsersController@restoreUser', 'as' => 'users.restore']);
    
    Route::resource('patients', 'Admin\PatientsController');
    Route::get('patients_get_info', ['uses' => 'Admin\PatientsController@get_info', 'as' => 'patients.get_info']);
    Route::post('patients_mass_destroy', ['uses' => 'Admin\PatientsController@massDestroy', 'as' => 'patients.mass_destroy']);

    Route::resource('nurses', 'Admin\NursesController');
    Route::post('nurses_mass_destroy', ['uses' => 'Admin\NursesController@massDestroy', 'as' => 'nurses.mass_destroy']);
    
    Route::get('get-doctors', 'Admin\DoctorsController@GetDoctors');
    Route::resource('doctors', 'Admin\DoctorsController');
    Route::post('doctors_mass_destroy', ['uses' => 'Admin\DoctorsController@massDestroy', 'as' => 'doctors.mass_destroy']);
    
    Route::resource('working_hours', 'Admin\WorkingHoursController');
    Route::post('working_hours_mass_destroy', ['uses' => 'Admin\WorkingHoursController@massDestroy', 'as' => 'working_hours.mass_destroy']);
    
    Route::resource('appointments', 'Admin\AppointmentsController');
    Route::get('appointments_get_appt', ['uses' => 'Admin\AppointmentsController@get_appt', 'as' => 'appointments.get_appt']);
    Route::get('appointments_create_appt', ['uses' => 'Admin\AppointmentsController@create_appt', 'as' => 'appointments.create_appt']);
    Route::post('appointments_store_appt', ['uses' => 'Admin\AppointmentsController@store_appt', 'as' => 'appointments.store_appt']);
    Route::get('appointments_edit_appt/{id}', ['uses' => 'Admin\AppointmentsController@edit_appt', 'as' => 'appointments.edit_appt']);
    Route::put('appointments_update_appt/{id}', ['uses' => 'Admin\AppointmentsController@update_appt', 'as' => 'appointments.update_appt']);
    Route::get('appointments_show_appt/{id}', ['uses' => 'Admin\AppointmentsController@show_appt', 'as' => 'appointments.show_appt']);
    Route::delete('appointments_destroy_appt/{id}', ['uses' => 'Admin\AppointmentsController@destroy_appt', 'as' => 'appointments.destroy_appt']);
    Route::post('appointments_mass_destroy', ['uses' => 'Admin\AppointmentsController@massDestroy', 'as' => 'appointments.mass_destroy']);
    
    Route::resource('services', 'Admin\ServicesController');
	Route::post('services_mass_destroy', ['uses' => 'Admin\ServicesController@massDestroy', 'as' => 'services.mass_destroy']);	
});