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

namespace Hyperf\MultiTenant\Traits;

use Hyperf\MultiTenant\Database\Connection;

trait TenantAwareConnection
{
    public function getConnectionName()
    {
        /** @var Connection $connection */
        $connection = app(Connection::class);

        if ($connection->exists()) {
            return $connection->tenantName();
        }

        return $connection->systemName();
    }
}
