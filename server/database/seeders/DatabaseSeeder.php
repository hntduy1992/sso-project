<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departmentRoot = Department::create([
            'name' => 'Root',
            'parent_id' => 0,
            'description' => 'Root department',
            'address' => 'Root address',
            'phone' => 'Root phone',
            'status' => 'active',
        ]);

        $userRoot = User::create([
            'username' => 'root',
            'password' => Hash::make('123456'),
            'department_id' => $departmentRoot->id,
            'status' => 'active',
        ]);

        $updateSelf = Permission::create(['name' => 'update self']);
        $viewSelf = Permission::create(['name' => 'view self']);
        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo([$updateSelf, $viewSelf]);

        $createUsers = Permission::create(['name' => 'create users']);
        $updateUsers = Permission::create(['name' => 'update users']);
        $deleteUsers = Permission::create(['name' => 'delete users']);
        $viewUsers = Permission::create(['name' => 'view users']);

        $roleUserManage = Role::create(['name' => 'users manager']);
        $roleUserManage->givePermissionTo([$createUsers, $updateUsers, $deleteUsers, $viewUsers]);

        $createDepartments = Permission::create(['name' => 'create departments']);
        $updateDepartments = Permission::create(['name' => 'update departments']);
        $deleteDepartments = Permission::create(['name' => 'delete departments']);
        $viewDepartments = Permission::create(['name' => 'view departments']);

        $roleDepartmentManage = Role::create(['name' => 'departments manager']);
        $roleDepartmentManage->givePermissionTo([$createDepartments, $updateDepartments, $deleteDepartments, $viewDepartments]);

        $roleRoot = Role::create(['name' => 'root']);

        $userRoot->assignRole(['root', 'user', 'departments manager', 'users manager']);
    }
}
