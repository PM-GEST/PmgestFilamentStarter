<?php

namespace PmGest\FilamentStarter\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallPackage extends Command
{
    protected $signature = 'pmgest-filament-starter:install';

    protected $description = 'Installation de toutes les dépendances du package';

    public function handle()
    {
        // Installation de filament
        $this->call('filament:install', [
            '--no-interaction' => true,
        ]);
        $this->info('Filament installé');

        $this->call('vendor:publish', ['--tag' => 'filament-panel-provider']);
        $this->call('vendor:publish', ['--tag' => 'routes']);

        // Installation des packages de dev
        $this->info('Installation des dépendances de dev...');

        $packages = [
           //'laravel/dusk:^8.3',
        ];

        foreach ($packages as $package) {
            $this->info("→ Installation de {$package}");
            $process = Process::fromShellCommandline("composer require --dev {$package}");
            $process->setTimeout(null);
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        }


        $this->info('✅ Dépendances de dev installées !');
    }

}