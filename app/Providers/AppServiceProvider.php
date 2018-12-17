<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;

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
        Blade::directive('role', function (string $expression): string {
            // Chose the role of the current user
            // $userRole = $roles[$expression];
            $currentRole = CheckRole::$roles[$expression];

            return "
                <?php
                    if (Auth::user()->role_id <= $currentRole):
                ?>
            ";
        });

        /**
         * EndRole blade dirrective
         *
         * @param  string  $expression
         * @return string
         */
        Blade::directive('endrole', function($expression): string {
            return '<?php
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
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

}
