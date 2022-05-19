<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call Permission Table Seeder
        $this->call(PermissionTableSeeder::class);

        // Call Role Table Seeder
        $this->call(RoleTableSeeder::class);

        // Call User Table Seeder
        $this->call(UserTableSeeder::class);

        //Call Restaurant Table Seeder
        $this->call(RestaurantsTableSeeder::class);

        //Call Customer Table Seeder
        $this->call(CustomersTableSeeder::class);

        //Call Units Table Seeder
        $this->call(UnitsTableSeeder::class);

        //Call Units Product_category Seeder
        $this->call(ProductCategorySeeder::class);

    }
}
