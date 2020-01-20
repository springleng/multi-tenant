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

namespace Hyperf\MultiTenant\Events\Hostnames;

use Hyperf\MultiTenant\Abstracts\AbstractEvent;
use Hyperf\MultiTenant\Contracts\Hostname;
use Hyperf\MultiTenant\Contracts\Website;

class Attached extends AbstractEvent
{
    /**
     * @var Hostname
     */
    public $hostname;

    /**
     * @var Website
     */
    public $website;

    public function __construct(Hostname &$hostname, Website &$website)
    {
        $this->hostname = &$hostname;
        $this->website = &$website;
    }
}
