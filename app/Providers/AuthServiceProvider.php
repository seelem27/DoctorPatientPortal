<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_status', function ($user) {
            return in_array($user->role_id, [1]);
        });
		
        // Auth gates for: Services
        Gate::define('service_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('service_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('service_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('service_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('service_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });		

        // Auth gates for: Patients
        Gate::define('patient_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('patient_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('patient_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('patient_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('patient_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });        
        Gate::define('patient_info', function($user){
            return in_array($user->role_id, [4]);
        });

        // Auth gates for: Nurses
        Gate::define('nurse_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('nurse_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('nurse_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('nurse_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('nurse_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Doctors
        Gate::define('doctor_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('doctor_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('doctor_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('doctor_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('doctor_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Working hours
        Gate::define('working_hour_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('working_hour_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('working_hour_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('working_hour_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('working_hour_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Appointments
        Gate::define('appointment_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('appointment_create', function ($user) {
            return in_array($user->role_id, [1, 2, 4]);
        });
        Gate::define('appointment_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 4]);
        });
        Gate::define('appointment_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4]);
        });
        Gate::define('appointment_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 4]);
        });
        Gate::define('appointment_info', function($user){
            return in_array($user->role_id, [4]);
        });
    }
}
