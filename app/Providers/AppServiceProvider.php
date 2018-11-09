<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Roles blade dirrective
         *
         * @param  string  $expression
         * @return string
         */
        Blade::directive('role', function (string $expression) {
            // Create a list of roles
            $this->roles = [
                'admin' => 1,
                'moder' => 2,
                'user' => 3,
            ];

            // Chose the role of the current user
            $userRole = $this->roles[$expression];

            return "
                <?php
                    if (Auth::user()->role_id <= $userRole):
                ?>
            ";
        });

        /**
         * EndRole blade dirrective
         *
         * @param  string  $expression
         * @return string
         */
        Blade::directive('endrole', function($expression) {
            return '<?php
                    else:
                    endif;
                ?>
            ';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
