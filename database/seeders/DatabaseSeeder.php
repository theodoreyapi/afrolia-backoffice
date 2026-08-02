<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('parametres')->insert([
            ['cle' => 'commission_defaut', 'valeur' => '15', 'description' => 'Commission par défaut en % appliquée aux nouveaux services', 'created_at' => now(), 'updated_at' => now()],
            ['cle' => 'frais_annulation', 'valeur' => '0', 'description' => 'Frais d\'annulation en % du montant du service', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
