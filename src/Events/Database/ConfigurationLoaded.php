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

namespace Hyperf\MultiTenant\Events\Database;

use Hyperf\MultiTenant\Abstracts\AbstractEvent;
use Hyperf\MultiTenant\Database\Connection;
use Hyperf\MultiTenant\Contracts\Website;

class ConfigurationLoaded extends AbstractEvent
{
    /**
     * @var array
     */
    public $configuration;

    /**
     * @var Connection
     */
    public $connection;

    /**
     * @var Website
     */
    public $website;

    /**
     * @param array      $configuration
     * @param Connection $connection
     * @param Website    $website
     */
    public function __construct(array &$configuration, Connection &$connection, Website $website)
    {
        $this->configuration = &$configuration;
        $this->connection = &$connection;
        $this->website = $website;
    }
}
