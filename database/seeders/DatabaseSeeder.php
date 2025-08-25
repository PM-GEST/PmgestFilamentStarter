<?php


use App\Models\User;
use Illuminate\Database\Seeder;
use function bcrypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création de l'utilisateur admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@pm-gest.com',
            'password' => bcrypt('PMgest21@'),
        ]);

    }
}
