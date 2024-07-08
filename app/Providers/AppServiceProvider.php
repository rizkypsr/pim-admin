<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });

        Blade::directive('rupiah', function ($expression) {
            return "Rp. <?= number_format($expression, 0, ',', '.'); ?>";
        });

        // Blade::directive('toWhatsapp', function ($expression) {
        //     return 'https://wa.me/' . '62' . substr($expression, 1);
        // });

        Blade::directive('toWhatsapp', function ($number) {
            return "<?php echo 'https://wa.me/' . '62' . substr($number, 1); ?>";
        });
    }
}
