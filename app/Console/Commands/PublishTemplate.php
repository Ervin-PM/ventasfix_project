<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publica los assets del template a public/template para que las vistas los consuman.';

    public function handle(Filesystem $files)
    {
        $this->info('Publicando assets del template...');
        $src = base_path('template');
        $dest = public_path('template');

        if (! $files->isDirectory($src)) {
            $this->error("Carpeta de template no encontrada en: {$src}");
            return 1;
        }

        // Crear destino si no existe
        if (! $files->isDirectory($dest)) {
            $files->makeDirectory($dest, 0755, true);
        }

        // Copiar recursivamente
        $files->copyDirectory($src, $dest);

        $this->info('Template publicado en public/template.');
        return 0;
    }
}
