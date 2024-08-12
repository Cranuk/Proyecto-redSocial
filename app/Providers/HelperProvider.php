<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // NOTE: Creamos nuestro propio provedor servicio para tener nuestras directivas separadas
        Blade::directive('countLikes', function ($expression) {
            return "<?php echo \App\Helpers\Helpers::countLikes($expression); ?>";
        });

        // NOTE: Creamos nuestro propio provedor servicio para tener nuestras directivas separadas
        Blade::directive('countComments', function ($expression) {
            return "<?php echo \App\Helpers\Helpers::countComments($expression); ?>";
        });

        // NOTE: Creamos nuestro propio servicio para tener nuestras directivas separadas
        Blade::directive('formatDate', function ($expression) {
            return "<?php echo \App\Helpers\Helpers::formatDate($expression); ?>";
        });
    }
}
