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

namespace Hyperf\MultiTenant\Providers\Webserver;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Hyperf\MultiTenant\Listeners;

class EventProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $subscribe = [
        Listeners\Servant::class,
    ];

    public function boot()
    {
        foreach ($this->subscribe as $listener) {
            $this->app[Dispatcher::class]->subscribe($listener);
        }
    }

    public function register()
    {
        // ..
    }
}
