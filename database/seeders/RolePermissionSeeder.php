<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'developer']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $createEmployeePermission = Permission::create(['name' => 'create employee']);
        $editEmployeePermission = Permission::create(['name' => 'edit employee']);
        $viewEmployeePermission = Permission::create(['name'=> 'view employee']);
        $deleteEmployeePermission = Permission::create(['name' => 'delete employee']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([$createEmployeePermission, $editEmployeePermission, $deleteEmployeePermission, $viewEmployeePermission]);
        $managerRole->givePermissionTo([$createEmployeePermission, $editEmployeePermission, $viewEmployeePermission]);
        $userRole->givePermissionTo($createEmployeePermission, $viewEmployeePermission);
    }
}
