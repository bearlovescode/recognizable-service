<?php
    namespace Bearlovescode\RecognizableService\Providers;

    use Bearlovescode\RecognizableService\Models\Configuration;
    use Bearlovescode\RecognizableService\Services\WebfingerService;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\ServiceProvider;

    class WellKnownServiceProvider extends ServiceProvider
    {
        public function boot() {}
        public function register()
        {
            parent::register();

            $this->handleMigrations();
            $this->handleRoutes();
            $this->setUpServices();
        }

        private function setUpServices(): void
        {
            // Webfinger.
            $webfingerConfig = new Configuration([
                'host' => Request::getHost()
            ]);
            $this->app->singleton(WebfingerService::class, function () use ($webfingerConfig) {
                return new WebfingerService($webfingerConfig);
            });

        }

        private function handleMigrations(): void
        {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }

        private function handleRoutes(): void
        {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        }
    }