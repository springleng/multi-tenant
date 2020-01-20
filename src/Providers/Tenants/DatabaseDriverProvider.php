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

use Hyperf\MultiTenant\Database\Connection;
use Hyperf\MultiTenant\Generators\Webserver\Database\DatabaseDriverFactory;
use Hyperf\MultiTenant\Generators\Webserver\Database\Drivers\MariaDB;
use Hyperf\MultiTenant\Generators\Webserver\Database\Drivers\PostgreSQL;
use Hyperf\MultiTenant\Generators\Webserver\Database\Drivers\PostgresSchema;
use Illuminate\Support\ServiceProvider;

class DatabaseDriverProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tenancy.db.drivers', function () {
            return collect($this->drivers());
        });

        $this->app->singleton(DatabaseDriverFactory::class);
    }

    protected function drivers()
    {
        $isPgsqlSchema = config('tenancy.db.tenant-division-mode') === Connection::DIVISION_MODE_SEPARATE_SCHEMA;

        return [
            'pgsql' => $isPgsqlSchema ? PostgresSchema::class : PostgreSQL::class,
            'mysql' => MariaDB::class,
        ];
    }
}
