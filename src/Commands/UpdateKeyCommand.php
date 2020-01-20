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

namespace Hyperf\MultiTenant\Commands;

use Hyperf\MultiTenant\Events\KeyUpdated;
use Hyperf\MultiTenant\Traits\DispatchesEvents;
use Illuminate\Console\Command;

class UpdateKeyCommand extends Command
{
    use DispatchesEvents;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:key:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tenant users passwords.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->emitEvent(new KeyUpdated());
    }
}
