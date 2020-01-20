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

namespace Hyperf\MultiTenant\Listeners\Database;

use Hyperf\MultiTenant\Abstracts\WebsiteEvent;
use Hyperf\MultiTenant\Database\Connection;
use Hyperf\MultiTenant\Traits\DispatchesEvents;
use Illuminate\Contracts\Events\Dispatcher;
use Hyperf\MultiTenant\Events;

class MigratesTenants
{
    use DispatchesEvents;
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Events\Websites\Created::class, [$this, 'migrate']);
    }

    /**
     * @param WebsiteEvent $event
     * @return bool
     */
    public function migrate(WebsiteEvent $event): bool
    {
        $paths = $this->getMigrationPaths();

        $migrated = false;

        foreach ($paths as $path) {
            if ($path && realpath($path) && $this->connection->migrate($event->website, $path)) {
                $migrated = true;
            }
        }

        if ($migrated) {
            $this->emitEvent(new Events\Websites\Migrated($event->website));
        }

        return true;
    }

    protected function getMigrationPaths()
    {
        if (($path = config('tenancy.db.tenant-migrations-path')) && ! empty($path)) {
            return (array) $path;
        }

        return [];
    }
}
