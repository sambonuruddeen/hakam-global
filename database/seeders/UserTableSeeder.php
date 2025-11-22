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
        Permission::create(['guard_name' => 'api', 'name' => 'create car']);
        Permission::create(['guard_name' => 'api', 'name' => 'view car']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit car']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete car']);


        // Web Permissions
        Permission::create(['guard_name' => 'web', 'name' => 'create car']);
        Permission::create(['guard_name' => 'web', 'name' => 'view car']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit car']);
        Permission::create(['guard_name' => 'web', 'name' => 'delete car']);

        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        #$admin->givePermissionTo(Permission::all());

        $user = Role::create(['name' => 'staff', 'guard_name' => 'api']);
        $user->givePermissionTo(['view car']);

        $supervisor = Role::create(['name' => 'supervisor', 'guard_name' => 'api']);
        $supervisor->givePermissionTo(['view car', 'edit car']);

        //  $staff = Role::create(['name' => 'staff', 'guard_name' => 'api']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Create users
        $users = ['admin', 'staff', 'supervisor'];
        foreach ($users as $user) {
            $new_user = User::factory()->create([
                'email' => $user . '@hakamglobal.com',
                'password' => Hash::make('password'),
                'phone_number' => '1234567890',
                'name' => ucwords($user),
                'email_verified_at' => now(),
                'two_factor_secret' => null, // Explicitly disable 2FA
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null, // Make sure this is null
            ]); // Ensure unique email for each role

            if ($user === 'admin') {
                $new_user->assignRole('admin');
            } else {
                $new_user->assignRole(Role::findByName($user, 'api'));
            }
        }
    }
}
