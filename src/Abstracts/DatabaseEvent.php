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

namespace Hyperf\MultiTenant\Abstracts;

use Hyperf\MultiTenant\Contracts\Website;

abstract class DatabaseEvent extends AbstractEvent
{
    /**
     * @var Website
     */
    public $website;

    /**
     * @var array
     */
    public $config;

    public function __construct(array &$config, Website $website = null)
    {
        $this->config = &$config;
        $this->website = &$website;
    }
}
