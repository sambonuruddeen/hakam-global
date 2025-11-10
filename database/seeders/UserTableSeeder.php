<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // API permissions
        Permission::create(['guard_name' => 'api', 'name' => 'create validation']);
        Permission::create(['guard_name' => 'api', 'name' => 'view validation']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit validation']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete validation']);
        

        // Web Permissions
        Permission::create(['guard_name' => 'web', 'name' => 'create validation']);
        Permission::create(['guard_name' => 'web', 'name' => 'view validation']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit validation']);
        Permission::create(['guard_name' => 'web', 'name' => 'delete validation']);

        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        #$admin->givePermissionTo(Permission::all());

        $enumerator = Role::create(['name' => 'enumerator', 'guard_name' => 'api']);
        $enumerator->givePermissionTo(['create validation']);

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);
        $userRole->givePermissionTo(['view validation']);
        
        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Create users
        $users = ['admin', 'enumerator', 'supervisor'];
        foreach ($users as $user) {
            $new_user = User::factory()->create([
                'email' => $user . '@fdc-app.com',
                'password' => Hash::make('password'),
                'name' => ucwords($user),
                'email_verified_at' => now(),
            ]); // Ensure unique email for each role

            if ($user === 'admin') {
                $new_user->assignRole('admin');
            } else {
                $new_user->assignRole(Role::findByName($user, 'api'));
            }
        }
    }
}
