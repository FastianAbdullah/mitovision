<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Check if the 'super admin' role exists
        if (!Role::where('name', 'super admin')->exists()) {
            // If it doesn't exist, create the 'super admin' role
            Role::create(['name' => 'super admin']);
        }
    
        // Check if the 'doctor' role exists
        if (!Role::where('name', 'doctor')->exists()) {
            // If it doesn't exist, create the 'doctor' role
            Role::create(['name' => 'doctor']);
        }
    
        // You can create other roles here in a similar manner if needed
    }
    public function register()
    {
        // Register stripe api key
        //$user = new User(Config::get('services.stripe.sk'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
}
