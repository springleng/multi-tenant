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

namespace Hyperf\MultiTenant\Events\Filesystem;

use Hyperf\MultiTenant\Abstracts\FilesystemEvent;

class DirectoryRenamed extends FilesystemEvent
{

    /**
     * @var string
     */
    public $old;

    /**
     * @param string $uuid
     * @return $this
     */
    public function setOld(string $uuid)
    {
        $this->old = $uuid;

        return $this;
    }
}
