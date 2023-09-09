<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $default_user = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();
        try {
            $admin = User::create(array_merge([
                'email' => 'admin@gmail.com',
                'name' => 'admin web',
            ], $default_user));
            $user = User::create(array_merge([
                'email' => 'user@gmail.com',
                'name' => 'user',
            ], $default_user));
            $driver = User::create(array_merge([
                'email' => 'driver@gmail.com',
                'name' => 'driver',
            ], $default_user));

            $roleAdmin = Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);
            Role::create(['name' => 'driver']);



            Permission::create(['name' => 'read']);
            Permission::create(['name' => 'create']);
            Permission::create(['name' => 'update']);
            Permission::create(['name' => 'delete']);
            Permission::create(['name' => 'admin']);

            $roleAdmin->givePermissionTo('read');
            $roleAdmin->givePermissionTo('create');
            $roleAdmin->givePermissionTo('update');
            $roleAdmin->givePermissionTo('delete');
            $roleAdmin->givePermissionTo('admin');


            $user->assignRole('user');
            $driver->assignRole('driver');
            $admin->assignRole('admin');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
