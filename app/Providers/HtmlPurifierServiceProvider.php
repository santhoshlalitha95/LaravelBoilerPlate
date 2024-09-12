<?php

namespace App\Providers;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\ServiceProvider;

class HtmlPurifierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HTMLPurifier::class, function ($app) {
            $config = HTMLPurifier_Config::createDefault();
            // Customize the config here if needed
            // For example, allow certain tags and attributes
            $config->set('HTML.Allowed', 'p,a[href],b,i,u,strong,em');
            $config->set('HTML.AllowedAttributes', 'a[href]');

            return new HTMLPurifier($config);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
