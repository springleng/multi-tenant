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

namespace Hyperf\MultiTenant\Events\Websites;

use Hyperf\MultiTenant\Abstracts\WebsiteEvent;
use Hyperf\MultiTenant\Contracts\Website;

class Switched extends WebsiteEvent
{
    /**
     * @var Website
     */
    public $old;

    /**
     * @param Website $website
     * @return $this
     */
    public function setOld(Website $website)
    {
        $this->old = $website;

        return $this;
    }
}
