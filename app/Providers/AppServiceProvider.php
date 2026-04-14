<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->specifyPasswordValidationRules();

        Paginator::useBootstrapFive();
    }

    /**
     * Specify the default validation rules for passwords
     *
     * @return void
     */
    private function specifyPasswordValidationRules()
    {
        Password::defaults(function () {
            // For strong password
            $rule = Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols();

            // For strong password in production
            return $this->app->isProduction()
                ? $rule->uncompromised()
                : $rule;
        });
    }
}
