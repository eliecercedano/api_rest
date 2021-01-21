<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (! Permission::where('name', 'role')->exists()){
            Permission::firstOrCreate(['name' => 'role','display_name' => 'Roles', 'description' => 'Roles']);        
            Permission::firstOrCreate(['name' => 'role-store','display_name' => 'Crear Rol', 'description' => 'Roles']);        
            Permission::firstOrCreate(['name' => 'role-show','display_name' => 'Mostrar Rol', 'description' => 'Roles']);        
            Permission::firstOrCreate(['name' => 'role-update','display_name' => 'Editar Rol', 'description' => 'Roles']);
            Permission::firstOrCreate(['name' => 'role-destroy','display_name' => 'Eliminar Rol', 'description' => 'Roles']);
        }
        
        if (! Permission::where('name', 'user')->exists()){
            Permission::firstOrCreate(['name' => 'user','display_name' => 'Usuarios', 'description' => 'Usuarios']);        
            Permission::firstOrCreate(['name' => 'user-store','display_name' => 'Crear Usuario', 'description' => 'Usuarios']);        
            Permission::firstOrCreate(['name' => 'user-show','display_name' => 'Mostrar Usuario', 'description' => 'Usuarios']);        
            Permission::firstOrCreate(['name' => 'user-update','display_name' => 'Editar Usuario', 'description' => 'Usuarios']);
            Permission::firstOrCreate(['name' => 'user-destroy','display_name' => 'Eliminar Usuario', 'description' => 'Usuarios']);
        }

        if (! Permission::where('name', 'permission')->exists()){
            Permission::firstOrCreate(['name' => 'permission','display_name' => 'Permisos', 'description' => 'Permisos']);        
            Permission::firstOrCreate(['name' => 'permission-store','display_name' => 'Crear Permiso', 'description' => 'Permisos']);        
            Permission::firstOrCreate(['name' => 'permission-show','display_name' => 'Mostrar Permiso', 'description' => 'Permisos']);        
            Permission::firstOrCreate(['name' => 'permission-update','display_name' => 'Editar Permiso', 'description' => 'Permisos']);
            Permission::firstOrCreate(['name' => 'permission-destroy','display_name' => 'Eliminar Permiso', 'description' => 'Permisos']);
        }

        $permissions = Permission::get();
        $admin = Role::where('name', 'admin')->first();
        if ($admin)
            $admin->syncPermissions($permissions);

        $this->command->info('Default permissions table seeded!');
    }
}
