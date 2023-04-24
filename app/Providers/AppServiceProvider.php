<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Log;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        

        try {
              DB::connection()->getPdo();   
        } catch (\Exception $e) {
          
            //Log::info("testing   ".print_r($e->getMessage(),true));
            return redirect('login')->with('danger','Could not connect to the database'.print_r($e->getMessage(),true));
            //return "Error connecting to database";
           // return redirect("login" .print_r($e->getMessage(),true))->withSuccess('Could not connect to the database');

         //die ("Could not connect to the database.  Please check your configuration. error:" );

        }
    }
}
