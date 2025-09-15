<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * Creates the application.
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        // Ensure API routes are loaded in this test environment
        if (file_exists(base_path('routes/api.php'))) {
            require base_path('routes/api.php');
        }

        // Log registered routes for debugging
        try {
            $routes = \Illuminate\Support\Facades\Route::getRoutes();
            $list = [];
            foreach ($routes as $r) {
                $list[] = (string) $r->uri();
            }
            @file_put_contents(base_path('storage/logs/routes-test.log'), implode("\n", $list));
        } catch (\Throwable $e) {
            // ignore
        }
        return $app;
    }
}
