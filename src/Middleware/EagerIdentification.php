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

namespace Hyperf\MultiTenant\Middleware;

use Closure;
use Hyperf\MultiTenant\Environment;
use Illuminate\Http\Request;

class EagerIdentification
{
    public function handle(Request $request, Closure $next)
    {
        if (config('tenancy.hostname.early-identification')) {
            app(Environment::class);
        }

        return $next($request);
    }
}
