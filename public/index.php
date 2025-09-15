<?php

/**
 * Public front controller for the Laravel application.
 * If the real Laravel `public/index.php` was missing, this minimal file
 * boots the framework using the application's bootstrap.
 */

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
