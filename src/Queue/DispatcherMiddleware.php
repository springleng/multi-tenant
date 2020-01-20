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

namespace Hyperf\MultiTenant\Queue;

use Hyperf\MultiTenant\Environment;
use Hyperf\MultiTenant\Contracts\Repositories\WebsiteRepository;

class DispatcherMiddleware
{
    public function handle($command, $next)
    {
        $key = $command->website_id ?? null;

        if ($key) {
            $environment = resolve(Environment::class);

            $repository = resolve(WebsiteRepository::class);

            $tenant = $repository->findById($key);

            $environment->tenant($tenant);
        }

        return $next($command);
    }
}
