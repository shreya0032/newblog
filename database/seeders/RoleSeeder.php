<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'super admin']);
        // $superAdmin->givePermissionTo('add');
        // $superAdmin->givePermissionTo('edit');
        // $superAdmin->givePermissionTo('details');
        // $superAdmin->givePermissionTo('delete');

        $permissions = Permission::pluck('id','id')->all();
   
        $superAdmin->syncPermissions($permissions);
     
        
    }
}
