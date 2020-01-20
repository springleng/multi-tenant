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
use Hyperf\Utils\Filesystem\Filesystem;

abstract class FilesystemEvent extends AbstractEvent
{
    /**
     * @var Filesystem
     */
    public $filesystem;
    /**
     * @var Website
     */
    public $website;

    public function __construct(Website $website, Filesystem $filesystem)
    {
        $this->website = $website;
        $this->filesystem = $filesystem;
    }
}
