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

namespace Hyperf\MultiTenant\Controllers;

use Hyperf\MultiTenant\Website\Directory;
use Illuminate\Support\Facades\Storage;

/**
 * Class MediaController
 *
 * @package Hyperf\MultiTenant\Controllers
 * @use Route::get('/media/{path}', Hyperf\MultiTenant\Controllers\MediaController::class)
 *          ->where('path', '.+')
 *          ->name('tenant.media');
 */
class MediaController
{
    /**
     * @var Directory
     */
    private $directory;

    public function __construct(Directory $directory)
    {
        $this->directory = $directory;
    }

    public function __invoke(string $path)
    {
        $path = "media/$path";

        if ($this->directory->exists($path)) {
            return response($this->directory->get($path))
                ->header('Content-Type', Storage::disk('tenant')->mimeType($path));
        }

        return abort(404);
    }
}
