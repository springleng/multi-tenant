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

namespace Hyperf\MultiTenant\Providers\Tenants;

use Hyperf\MultiTenant\Contracts\CurrentHostname;
use Hyperf\MultiTenant\Contracts\Tenant;
use Hyperf\MultiTenant\Environment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class HostnameProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [
            CurrentHostname::class,
            Tenant::class,
        ];
    }

    public function boot(Application $app)
    {
        $app->make(Environment::class);
    }
}
