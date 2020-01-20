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

namespace Hyperf\MultiTenant\Providers\Tenants;

use Hyperf\MultiTenant\Contracts\Website\UuidGenerator;
use Hyperf\MultiTenant\Exceptions\GeneratorInvalidException;
use Illuminate\Support\ServiceProvider;

class UuidProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UuidGenerator::class, function ($app) {
            $generator = $app['config']->get('tenancy.website.random-id-generator');

            if (class_exists($generator)) {
                return $app->make($generator);
            }

            throw new GeneratorInvalidException($generator);
        });
    }
}
