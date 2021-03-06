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

use Hyperf\MultiTenant\Contracts\Repositories\WebsiteRepository;
use Hyperf\MultiTenant\Database\Connection;
use Hyperf\Database\Migrations\Migrator;
use InvalidArgumentException;

trait MutatesMigrationCommands
{
    use AddWebsiteFilterOnCommand;
    /**
     * @var WebsiteRepository
     */
    private $websites;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);

        $this->setName('tenancy:' . $this->getName());
        $this->specifyParameters();

        $this->websites = app(WebsiteRepository::class);
        $this->connection = app(Connection::class);
    }

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->input->setOption('force', true);
        $this->input->setOption('database', $this->connection->tenantName());

        $this->processHandle();
    }

    /**
     * Get the path to the migration directory.
     *
     * @return array
     */
    protected function getMigrationPaths(): array
    {
        if ($this->input->hasOption('path') && $this->option('path')) {
            return parent::getMigrationPaths();
        }

        // Tenant migrations path is configured.
        if (($path = config('tenancy.db.tenant-migrations-path')) && ! empty($path)) {
            return (array) $path;
        }

        throw new InvalidArgumentException("To prevent unwanted migrations from database/migrations, always specify a path.");
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return array_merge([$this->addWebsiteOption()], parent::getOptions());
    }
}
