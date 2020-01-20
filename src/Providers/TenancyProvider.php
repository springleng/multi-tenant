<?php

declare(strict_types=1);
/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://tenancy.dev
 * @see https://github.com/hyn/multi-tenant
 */

namespace Hyperf\MultiTenant\Providers;

use Hyperf\MultiTenant\Commands\RunCommand;
use Hyperf\MultiTenant\Commands\RecreateCommand;
use Hyperf\MultiTenant\Commands\UpdateKeyCommand;
use Hyperf\MultiTenant\Contracts;
use Hyperf\MultiTenant\Environment;
use Hyperf\MultiTenant\Listeners\Database\FlushHostnameCache;
use Hyperf\MultiTenant\Repositories;
use Hyperf\MultiTenant\Providers\Tenants as Providers;
use Hyperf\MultiTenant\Contracts\Website as WebsiteContract;
use Hyperf\MultiTenant\Contracts\Hostname as HostnameContract;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class TenancyProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../assets/configs/tenancy.php',
            'tenancy'
        );

        $this->publishes(
            [__DIR__ . '/../../assets/migrations' => database_path('migrations')],
            'tenancy'
        );


        $this->app->booted(function ($app) {
            $app->singleton(Environment::class, function ($app) {
                return new Environment($app);
            });
        });
        $this->app->singleton(Contracts\Repositories\HostnameRepository::class, Repositories\HostnameRepository::class);
        $this->app->singleton(Contracts\Repositories\WebsiteRepository::class, Repositories\WebsiteRepository::class);

        $this->registerModels();

        $this->registerProviders();

        $this->registerMiddleware();
    }

    public function boot()
    {
        $this->bootCommands();

        $this->bootObservers();
    }

    protected function registerModels()
    {
        $config = $this->app['config']['tenancy.models'];

        $this->app->bind(HostnameContract::class, $config['hostname']);
        $this->app->bind(WebsiteContract::class, $config['website']);
    }

    protected function bootObservers()
    {
        forward_static_call([$this->app['config']['tenancy.models.hostname'], 'observe'], FlushHostnameCache::class);
    }

    protected function registerProviders()
    {
        $this->app->register(Providers\ConfigurationProvider::class);
        $this->app->register(Providers\PasswordProvider::class);
        $this->app->register(Providers\ConnectionProvider::class);
        $this->app->register(Providers\UuidProvider::class);
        $this->app->register(Providers\BusProvider::class);
        $this->app->register(Providers\FilesystemProvider::class);
        $this->app->register(Providers\HostnameProvider::class);
        $this->app->register(Providers\DatabaseDriverProvider::class);
        $this->app->register(Providers\QueueProvider::class);

        // Register last.
        $this->app->register(Providers\EventProvider::class);
        $this->app->register(Providers\RouteProvider::class);
    }

    protected function bootCommands()
    {
        $this->commands([
            RecreateCommand::class,
            RunCommand::class,
            UpdateKeyCommand::class,
        ]);
    }

    protected function registerMiddleware()
    {
        $middleware = $this->app['config']['tenancy.middleware'];

        /** @var Kernel|\Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);

        foreach ($middleware as $mw) {
            $kernel->prependMiddleware($mw);
        }
    }

    public function provides()
    {
        return [
            Environment::class,
            Contracts\Repositories\HostnameRepository::class,
            Contracts\Repositories\WebsiteRepository::class,
        ];
    }
}
