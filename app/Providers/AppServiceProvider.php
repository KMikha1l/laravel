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
        // Roles dirrective
        Blade::directive('role', function($expression) {
            $this->roles = array(
                'admin' => 1,
                'moder' => 2,
                'user' => 3,
            );

            $userRole = $this->roles[$expression];
            return "<?php
            if(Auth::user()->role_id <= $userRole): ?>";
        });


        Blade::directive('endrole', function($expression) {
            return '<?php
            else:
            endif;
            ?>';
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
