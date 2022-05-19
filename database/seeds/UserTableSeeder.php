<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superadmin = Role::where('name', 'super_admin')->first();
        $role_admin = Role::where('name', 'administrator')->first();
        $role_receptionist = Role::where('name', 'receptionist')->first();
        $role_cashier = Role::where('name', 'cashier')->first();
        $role_waiter = Role::where('name', 'waiter')->first();
        $role_chief = Role::where('name', 'chief')->first();
        $role_jannat = Role::where('name', 'jannat')->first();

        // Super Admin
        $superAdmin = new User();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@datatrix.dev';
        $superAdmin->password = bcrypt('password');
        $superAdmin->save();
        $superAdmin->attachRole($role_superadmin);

        // Admin
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@datatrix.dev';
        $admin->password = bcrypt('password');
        $admin->save();
        $admin->attachRole($role_admin);

        // receptionist
        $recep = new User();
        $recep->name = 'Receptionist';
        $recep->email = 'receptionist@datatrix.dev';
        $recep->password = bcrypt('password');
        $recep->save();
        $recep->attachRole($role_receptionist);

        // cashier
        $cashier = new User();
        $cashier->name = 'Cashier';
        $cashier->email = 'cashier@datatrix.dev';
        $cashier->password = bcrypt('password');
        $cashier->save();
        $cashier->attachRole($role_cashier);

        // waiter
        $waiter = new User();
        $waiter->name = 'Waiter';
        $waiter->email = 'waiter@datatrix.dev';
        $waiter->password = bcrypt('password');
        $waiter->save();
        $waiter->attachRole($role_waiter);

        // chief
        $chief = new User();
        $chief->name = 'Chief';
        $chief->email = 'chief@datatrix.dev';
        $chief->password = bcrypt('password');
        $chief->save();
        $chief->attachRole($role_chief);

        // chief
        $jannat = new User();
        $jannat->name = 'Jannat';
        $jannat->email = 'jannat@jannatrestaurant.com.bd';
        $jannat->password = bcrypt('password');
        $jannat->save();
        $jannat->attachRole($role_jannat);

        // More to come here
    }
}
