<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->configureAuth();
        $this->configureCommands();
        $this->configureDates();
        $this->configureModels();
        $this->configurePasswordValidation();
        $this->configureHttp();
        $this->configureGlobalSettings(); // New helper to load settings
        $this->configureRateLimiting();
    }

    private function configureGlobalSettings(): void
    {
        if (! $this->app->runningInConsole()) {
            $settings = cache()->remember('settings', 3600, fn () => Setting::all());
            foreach ($settings as $setting) {
                config()->set([$setting->key => $setting->value]);
            }
        }
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function configureAuth(): void
    {
        Gate::before(function (?User $user) {
            return $user?->hasRole('admin') ? true : null;
        });
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(Application::getInstance()->isProduction());
    }

    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    private function configureModels(): void
    {
        Model::shouldBeStrict(! Application::getInstance()->isProduction());
    }


private function configureHttp(): void
{
    \Illuminate\Support\Facades\Http::globalOptions([
        'headers' => [
            'User-Agent' => config('app.user_agent'),
        ],
    ]);

    if (app()->environment('production') || str_starts_with(config('app.url'), 'https://')) {
        URL::forceScheme('https');

        // KJO ËSHTË ZGJIDHJA KRITIKE PËR GABIMIN 401
        URL::forceRootUrl(config('app.url'));
    }
}

    private function configurePasswordValidation(): void
    {
        Password::defaults(fn () => Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->uncompromised()
        );
    }
}
