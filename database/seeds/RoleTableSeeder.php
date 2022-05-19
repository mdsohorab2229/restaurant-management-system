<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm_superadmin = Permission::all();
        $perm_admin = Permission::whereNotIn('name', ['manage_admin', 'manage_modules'])->get();
        $perm_cashier = Permission::whereIn('name', ['manage_cash'])->get();
        $perm_receptionist = Permission::whereIn('name', ['manage_receptionist'])->get();
        $perm_waiter = Permission::whereIn('name', ['manage_waiter'])->get();
        $perm_chief = Permission::whereIn('name', ['manage_chief'])->get();
        $perm_jannat = Permission::whereIn('name', ['manage_jannat'])->get();

        // Super Admin Role
        $superAdmin = new Role();
        $superAdmin->name = 'super_admin';
        $superAdmin->display_name = 'Super Admin';
        $superAdmin->description = 'Has all permissions for super administrator';
        $superAdmin->save();
        $superAdmin->attachPermissions($perm_superadmin);

        // Admin Role
        $admin = new Role();
        $admin->name = 'administrator';
        $admin->display_name = 'Administrator';
        $admin->description = 'Has all permissions for administrator';
        $admin->save();
        $admin->attachPermissions($perm_admin);

        // Cashier Role
        $admin = new Role();
        $admin->name = 'cashier';
        $admin->display_name = 'Cashier';
        $admin->description = 'Has all permissions for Cashier';
        $admin->save();
        $admin->attachPermissions($perm_cashier);

        // Receptionist Role
        $rcp = new Role();
        $rcp->name = 'receptionist';
        $rcp->display_name = 'Receptionist';
        $rcp->description = 'Has all permissions for Receptionist';
        $rcp->save();
        $rcp->attachPermissions($perm_receptionist);

        // waiter Role
        $waiter = new Role();
        $waiter->name = 'waiter';
        $waiter->display_name = 'Waiter';
        $waiter->description = 'Has all permissions for waiter';
        $waiter->save();
        $waiter->attachPermissions($perm_waiter);

        // Chief Role
        $chief = new Role();
        $chief->name = 'chief';
        $chief->display_name = 'Chief';
        $chief->description = 'Has all permissions for Chief';
        $chief->save();
        $chief->attachPermissions($perm_chief);

        // Jannat Role
        $jannat = new Role();
        $jannat->name = 'jannat';
        $jannat->display_name = 'Jannat';
        $jannat->description = 'Has all permissions for Jannat';
        $jannat->save();
        $jannat->attachPermissions($perm_jannat);

        // More to come here
    }
}
