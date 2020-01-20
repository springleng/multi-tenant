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

namespace Hyperf\MultiTenant;

use Hyperf\MultiTenant\Contracts\CurrentHostname;
use Hyperf\MultiTenant\Contracts\Hostname;
use Hyperf\MultiTenant\Contracts\Tenant;
use Hyperf\MultiTenant\Contracts\Website;
use Hyperf\MultiTenant\Database\Connection;
use Hyperf\MultiTenant\Events;
use Hyperf\MultiTenant\Jobs\HostnameIdentification;
use Hyperf\MultiTenant\Traits\DispatchesEvents;
use Hyperf\MultiTenant\Traits\DispatchesJobs;
use Illuminate\Contracts\Foundation\Application;
use Hyperf\Utils\Traits\Macroable;

class Environment
{
    use DispatchesJobs, DispatchesEvents, Macroable;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var bool
     */
    protected $installed;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->defaults();

        if ((! $app->runningInConsole() || $app->runningUnitTests()) &&
            $this->installed() &&
            config('tenancy.hostname.auto-identification')) {
            $this->identifyHostname();
            // Identifies the current hostname, sets the binding using the native resolving strategy.
            $app->make(CurrentHostname::class);
        }
    }

    public function installed(): bool
    {
        $isInstalled = function (): bool {
            /** @var \Illuminate\Database\Connection $connection */
            $connection = $this->app->make(Connection::class)->system();
            /** @var string $table */
            $table = $this->app->make(Website::class)->getTable();

            try {
                $tableExists = $connection->getSchemaBuilder()->hasTable($table);
            } finally {
                return $tableExists ?? false;
            }
        };

        return $this->installed ?? $this->installed = $isInstalled();
    }

    public function identifyHostname()
    {
        $this->app->singleton(CurrentHostname::class, function () {
            /** @var Hostname $hostname */
            $hostname = $this->dispatch(new HostnameIdentification());

            $this->tenant(optional($hostname)->website);

            return $hostname;
        });
    }

    /**
     * Get or set the current hostname.
     *
     * @param Hostname|null $hostname
     * @return Hostname|null
     */
    public function hostname(Hostname $hostname = null): ?Hostname
    {
        if ($hostname !== null) {
            $this->app->instance(CurrentHostname::class, $hostname);

            $this->emitEvent(new Events\Hostnames\Switched($hostname));

            return $hostname;
        }

        return $this->app->make(CurrentHostname::class);
    }

    public function website(): ?Website
    {
        $hostname = $this->hostname();

        return $hostname ? $hostname->website : null;
    }

    /**
     * Get or set current tenant.
     *
     * @param Website|null $website
     * @return Tenant|null
     */
    public function tenant(Website $website = null): ?Website
    {
        if ($website !== null) {
            $this->app->instance(Tenant::class, $website);

            $this->emitEvent(new Events\Websites\Switched($website));

            return $website;
        }

        return $this->app->make(Tenant::class);
    }

    protected function defaults()
    {
        $empty = function () {
            return null;
        };

        $this->app->singleton(Tenant::class, $empty);
        $this->app->singleton(CurrentHostname::class, $empty);
    }
}
