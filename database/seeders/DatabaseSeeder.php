<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminSeed = config('services.admin_seed');
        $adminEmail = $adminSeed['email'];
        $adminPassword = $adminSeed['password'];

        if ((bool) $adminEmail !== (bool) $adminPassword) {
            throw new RuntimeException('Configurez SEED_ADMIN_EMAIL et SEED_ADMIN_PASSWORD ensemble.');
        }

        if ($adminEmail && $adminPassword) {
            if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL) || strlen($adminPassword) < 12) {
                throw new RuntimeException('Le courriel du super-administrateur doit être valide et son mot de passe doit contenir au moins 12 caractères.');
            }

            User::firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => $adminSeed['name'] ?: 'Super Admin',
                    'password' => $adminPassword,
                    'type' => 'super_admin',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Appeler tous les seeders dans l'ordre
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CarouselSlideSeeder::class,
            ActivitySeeder::class,
            SiteSettingSeeder::class,
            PageContentsSeeder::class,
            MarqueCategorySeeder::class,
            MarqueProductsSeeder::class,
        ]);
    }
}
