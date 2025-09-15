<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DirectMigrate extends Command
{
    protected $signature = 'migrate:direct';
    protected $description = 'Run migration files directly and record them in migrations table (workaround)';

    public function handle()
    {
        $this->info('Running direct migrations...');

        // Ensure migrations table exists
        DB::statement("CREATE TABLE IF NOT EXISTS migrations (migration VARCHAR(255) NOT NULL, batch INTEGER NOT NULL);");

        $files = glob(database_path('migrations').'/*.php');
        usort($files, function($a,$b){ return strcmp($a,$b); });

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $exists = DB::table('migrations')->where('migration', $name)->exists();
            if ($exists) {
                $this->line("Skipping: $name (already recorded)");
                continue;
            }

            // include file and instantiate class
            $declaredBefore = get_declared_classes();
            require_once $file;
            $declaredAfter = get_declared_classes();
            $new = array_diff($declaredAfter, $declaredBefore);
            $class = null;
            foreach ($new as $c) {
                if (is_subclass_of($c, 'Illuminate\Database\Migrations\Migration') || preg_match('/^Create.*Table$/', $c)) {
                    $class = $c; break;
                }
            }
            if (!$class) {
                // fallback: pick last declared class
                $class = end($new) ?: null;
            }

            if ($class && class_exists($class)) {
                $this->line("Applying: $name => $class");
                try {
                    $obj = new $class;
                    if (method_exists($obj, 'up')) {
                        $obj->up();
                    }
                    $batch = DB::table('migrations')->max('batch') ?: 0;
                    $batch = max(1, $batch + 1);
                    DB::table('migrations')->insert(['migration' => $name, 'batch' => $batch]);
                } catch (\Throwable $e) {
                    $this->error("Failed $name: " . $e->getMessage());
                }
            } else {
                $this->warn("No migration class found in $file");
            }
        }

        $this->info('Direct migrations complete.');
        return 0;
    }
}
