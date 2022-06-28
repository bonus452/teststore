<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'user']);
        $role = Role::create(['name' => 'sale manager']);

        $admin_panel = Permission::create(['name' => 'admin-panel']);
        $admin_panel->assignRole('admin', 'sale manager');

        $admin = User::find(1);
        $admin->assignRole('admin');
        $guest = User::find(2);
        $guest->assignRole('user');

    }
}
