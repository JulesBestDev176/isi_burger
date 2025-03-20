<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::create([
            'nom' => 'admin',  
            'prenom' => 'admin',  
            'email' => 'souleymanefall176@gmail.com',
            'password' => bcrypt('admin'), 
        ]);
        $admin->assignRole($adminRole);
        
    }
}
