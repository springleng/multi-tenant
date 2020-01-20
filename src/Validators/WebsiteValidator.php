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

namespace Hyperf\MultiTenant\Validators;

use Hyperf\MultiTenant\Abstracts\Validator;

class WebsiteValidator extends Validator
{
    protected $create = [
        'uuid' => ['required', 'string', "unique:%system%.%websites%,uuid"],
    ];
    protected $update = [
        'uuid' => ['required', 'string', "unique:%system%.%websites%,uuid,%id%"],
    ];
}
