<?php

namespace PmGest\FilamentStarter\Commands;

use Illuminate\Console\Command;

/**
 * Commande permettant de reinitialiser la base de données, de la remplir avec les données de seeders et de créer un super administrateur.
 */
class Refresh extends Command
{
    // php artisan app:refresh --> formulaire de la commande
    protected $signature = 'app:refresh';

    protected $description = 'Refreshing the app by resetting the database, seeding it, and creating a super admin user.';

    public function handle()
    {
        // Refresh de la base de données
        $this->call('migrate:fresh', [
            '--force' => true,
        ]);

        // Appel des seeder (voir DatabaseSeeder.php)
        $this->call('db:seed', [
            '--force' => true,
        ]);

        $this->info('✅ Application refreshed successfully!');
    }
}
