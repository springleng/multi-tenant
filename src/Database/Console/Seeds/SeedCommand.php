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

namespace Hyperf\MultiTenant\Database\Console\Seeds;

use Hyperf\MultiTenant\Traits\MutatesSeedCommands;
use Hyperf\Database\Commands\Seeders\SeedCommand as BaseCommand;

class SeedCommand extends BaseCommand
{
    use MutatesSeedCommands;
}
