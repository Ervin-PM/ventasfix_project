<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind a tolerant migration repository that handles array/stdClass results
        $this->app->bind('migration.repository', function ($app) {
            $resolver = $app['db'];
            $table = $app['config']->get('database.migrations', 'migrations');
            return new class($resolver, $table) extends DatabaseMigrationRepository {
                public function getRan()
                {
                    $results = $this->table()
                        ->orderBy('batch', 'asc')
                        ->orderBy('migration', 'asc')
                        ->get();

                    $migrations = [];
                    foreach ($results as $r) {
                        if (is_array($r)) {
                            $migrations[] = $r['migration'] ?? null;
                        } elseif (is_object($r)) {
                            // object may expose numeric properties, try casts
                            if (isset($r->migration)) {
                                $migrations[] = $r->migration;
                            } else {
                                $vars = get_object_vars($r);
                                if (isset($vars['migration'])) $migrations[] = $vars['migration'];
                                else $migrations[] = null;
                            }
                        }
                    }

                    return array_filter($migrations);
                }
            };
        });

        // Provide a minimal queue.listener stub to satisfy artisan/test boot in this snapshot
        if (! $this->app->bound('queue.listener')) {
            $this->app->singleton('queue.listener', function () {
                return new \App\Support\ListenerStub();
            });
        }

        // Provide a minimal queue stub to satisfy any 'queue' resolution during bootstrap
        if (! $this->app->bound('queue')) {
            $this->app->singleton('queue', function () {
                return new \App\Support\QueueStub();
            });
        }

        // Provide a minimal queue.worker stub for console commands
        if (! $this->app->bound('queue.worker')) {
            $this->app->singleton('queue.worker', function () {
                return new \App\Support\WorkerStub();
            });
        }

        // If Fruitcake CORS middleware is referenced but the package is not installed in this snapshot,
        // map the expected class name to our local stub so kernel resolution succeeds.
        if (! class_exists('\Fruitcake\\Cors\\HandleCors') && class_exists(\App\Support\Fruitcake\HandleCors::class)) {
            class_alias(\App\Support\Fruitcake\HandleCors::class, 'Fruitcake\\Cors\\HandleCors');
        }
    }

    public function boot()
    {
        // no-op
    }
}
