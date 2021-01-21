<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

use DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::where('name', 'admin')->first();
        $role = Role::where('name', 'admin')->first();

        if (! DB::table('role_user')->where('role_id', $role->id)->where('user_id', $user->id)->exists()) {
            DB::table('role_user')->insert([
                [            
                    'role_id' =>  $role->id,  
                    'user_id' =>  $user->id,
                    'user_type' => 'App\User'
                ], 
            ]);
            $this->command->info('Default admin role user was generated!');
        }
        
    }
}
