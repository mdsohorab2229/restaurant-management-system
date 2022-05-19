<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm1 = new Permission();
        $perm1->name = 'manage_admin'; // for super admin
        $perm1->display_name = 'Manage Admin';
        $perm1->description = 'Can create, edit or delete an admin';
        $perm1->save();

        $perm2 = new Permission();
        $perm2->name = 'manage_module'; // for super admin
        $perm2->display_name = 'Manage Modules';
        $perm2->description = 'Can manage modules';
        $perm2->save();

        $perm3 = new Permission();
        $perm3->name = 'manage_settings'; // for admin
        $perm3->display_name = 'Manage Settings';
        $perm3->description = 'Can manage settings';
        $perm3->save();

        $perm10 = new Permission();
        $perm10->name = 'view_user';
        $perm10->display_name = 'View Users';
        $perm10->description = 'Can view users';
        $perm10->save();
        
        $perm11 = new Permission();
        $perm11->name = 'manage_user';
        $perm11->display_name = 'Manage User';
        $perm11->description = 'Can CRUD user\'s informations';
        $perm11->save();

        $perm12 = new Permission();
        $perm12->name = 'view_user_role';
        $perm12->display_name = 'View User Roles';
        $perm12->description = 'Can view user roles';
        $perm12->save();
        
        $perm13 = new Permission();
        $perm13->name = 'manage_user_role';
        $perm13->display_name = 'Manage User Roles';
        $perm13->description = 'Can CRUD user roles';
        $perm13->save();
        
        $perm14 = new Permission();
        $perm14->name = 'manage_cash';
        $perm14->display_name = 'Manage Cash';
        $perm14->description = 'Can do cash related';
        $perm14->save();
        
        $perm15 = new Permission();
        $perm15->name = 'manage_receptionist';
        $perm15->display_name = 'Manage Receptionist';
        $perm15->description = 'can do Receptionist Related';
        $perm15->save();
        
        $perm16 = new Permission();
        $perm16->name = 'manage_waiter';
        $perm16->display_name = 'Manage Waiter ';
        $perm16->description = 'can do Waiter Related';
        $perm16->save();
        
        $perm17 = new Permission();
        $perm17->name = 'manage_chief';
        $perm17->display_name = 'Manage Chief ';
        $perm17->description = 'can do Chief Related';
        $perm17->save();

        $perm18 = new Permission();
        $perm18->name = 'manage_jannat';
        $perm18->display_name = 'Manage Jannat ';
        $perm18->description = 'can do Jannat Related';
        $perm18->save();

    }
}
