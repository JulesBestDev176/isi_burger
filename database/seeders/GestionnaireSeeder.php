<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gestionnaireRole = Role::firstOrCreate(['name' => 'gestionnaire']);
        $gestionnaire = User::create([
            'nom' => 'fall',  
            'prenom' => 'souleymane',  
            'email' => 'souleymanefallisidk@groupeisi.com',
            'password' => bcrypt('okok'), 
        ]);
        $gestionnaire->assignRole($gestionnaireRole);
    }
}
