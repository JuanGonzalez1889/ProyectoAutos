<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

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
        // Forzar HTTPS en producción
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        // Directiva Blade para sanitizar HTML
        Blade::directive('sanitize', function ($expression) {
            return "<?php echo e(strip_tags($expression)); ?>";
        });
        
        // Directiva Blade para reCAPTCHA v3
        Blade::directive('recaptcha', function ($action = 'submit') {
            return <<<HTML
                <?php if(config('services.recaptcha.site_key')): ?>
                    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo config('services.recaptcha.site_key'); ?>"></script>
                    <script>
                        grecaptcha.ready(function() {
                            grecaptcha.execute('<?php echo config('services.recaptcha.site_key'); ?>', {action: $action})
                            .then(function(token) {
                                document.querySelector('[name="g-recaptcha-response"]').value = token;
                            });
                        });
                    </script>
                <?php endif; ?>
            HTML;
        });
    }
}
