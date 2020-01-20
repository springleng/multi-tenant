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

namespace Hyperf\MultiTenant\Listeners;

use Hyperf\MultiTenant\Contracts\Website\UuidGenerator;
use Hyperf\MultiTenant\Events\Websites\Creating;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;

class WebsiteUuidGeneration
{
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var UuidGenerator
     */
    private $generator;

    /**
     * WebsiteUuidGeneration constructor.
     * @param Repository $config
     * @param UuidGenerator $generator
     */
    public function __construct(Repository $config, UuidGenerator $generator)
    {
        $this->config = $config;
        $this->generator = $generator;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Creating::class, [$this, 'addUuid']);
    }

    /**
     * @param Creating $event
     */
    public function addUuid(Creating $event)
    {
        if (! $event->website->uuid && $this->config->get('tenancy.website.disable-random-id') !== true) {
            $event->website->uuid = $this->generator->generate($event->website);
        }
    }
}
