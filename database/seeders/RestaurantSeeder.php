<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([
            [
                'nom' => 'Le Gourmet',
                'tel' => '1234567890',
                'email' => 'legourmet@example.com',
                'adresse' => '10 Rue de la Cuisine',
                'ville' => 'Dakar',
                'code_postal' => '12345',
                'description' => 'Restaurant gastronomique offrant une expérience culinaire unique.',
                'logo' => 'gourmet_logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
