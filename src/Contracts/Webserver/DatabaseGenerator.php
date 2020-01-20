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

namespace Hyperf\MultiTenant\Contracts\Webserver;

use Hyperf\MultiTenant\Contracts\Website;
use Hyperf\MultiTenant\Database\Connection;
use Hyperf\MultiTenant\Events\Websites\Created;
use Hyperf\MultiTenant\Events\Websites\Deleted;
use Hyperf\MultiTenant\Events\Websites\Updated;

interface DatabaseGenerator
{
    public function created(Created $event, array $config, Connection $connection): bool;
    public function updated(Updated $event, array $config, Connection $connection): bool;
    public function deleted(Deleted $event, array $config, Connection $connection): bool;
    public function updatePassword(Website $website, array $config, Connection $connection): bool;
}
