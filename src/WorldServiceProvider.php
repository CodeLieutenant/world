<?php

namespace Nnjeim\World;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;

class WorldServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register the main class to use with the facade
        $this->app->singleton('world', WorldHelper::class);
        $this->app->singleton(WorldHelper::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/world.php', 'world');
    }

    public function boot(Config $config): void
    {
        if ($config->get('world.routes')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/index.php');
        }

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'world');

        if ($this->app->runningInConsole()) {
            // Load migrations
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            // Publish the resources.
            $this->publishResources();
            // Load commands
            $this->loadCommands();
        }
    }

    /**
     * Method to publish the resource to the app resources folder
     * @return void
     */
    private function publishResources(): void
    {
        $this->publishes([
            __DIR__ . '/../config/world.php' => config_path('world.php'),
        ], ['world', 'world-config']);

        $this->publishes([
            __DIR__ . '/Database/Seeders/WorldSeeder.php' => database_path('seeders/WorldSeeder.php'),
        ], ['world', 'world-seeder']);

        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->app->langPath('vendor/world'),
        ], ['world', 'world-lang']);

        $method = match (method_exists($this, 'publishesMigrations')) {
            true => 'publishesMigrations',
            default => 'publishes',
        };

        $this->{$method}([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], ['world', 'world-migrations']);
    }

    /**
     * Method to publish the resource to the app resources folder
     * @return void
     */
    private function loadCommands(): void
    {
        $this->commands([
            Commands\InstallWorldData::class,
            Commands\RefreshWorldData::class,
        ]);
    }
}
