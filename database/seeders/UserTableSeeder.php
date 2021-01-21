<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (! User::where('name', 'admin')->exists()){
            $admin = User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '123456'
            ]);

            $this->command->info('Default user table seeded!');
        }
    }
}
