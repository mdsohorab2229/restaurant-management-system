<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $customer = new Customer();
        $customer->restaurant_id = 1;
        $customer->name = 'Walk-in customer';
        $customer->save();

    }
}
