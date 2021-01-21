<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (! Role::where('name', 'admin')->exists()){
            $admin = Role::create([
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Usuario Administrador de la API',
            ]);

            $this->command->info('Default role table seeded!');
        }
    }
}
