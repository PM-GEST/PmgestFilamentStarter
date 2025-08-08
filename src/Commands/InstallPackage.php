<?php

namespace PmGest\FilamentStarter\Commands;

use Illuminate\Console\Command;

class InstallPackage extends Command
{
    protected $signature = 'pmgest-filament-starter:install';

    protected $description = 'Installation de toutes les dépendances du package';

    public function handle()
    {
        $this->call('filament:install');
        $this->info('Filament installé');

        $this->call('dusk:install');
        $this->info('Dusk installé');
    }

}