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

use Hyperf\MultiTenant\Contracts\Hostname;
use Hyperf\MultiTenant\Contracts\Website;

trait ConvertsEntityToWebsite
{
    /**
     * @param $entity
     * @return Website|null
     */
    protected function convertWebsiteOrHostnameToWebsite($entity)
    {
        $website = null;

        if ($entity instanceof Hostname) {
            $website = $entity->website;
        }

        if ($entity instanceof Website) {
            $website = $entity;
        }

        return $website;
    }
}
