<?php

use Illuminate\Database\Seeder;
use App\Restaurant;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rest = new Restaurant();
        $rest->name = 'Jannat Restaurant & Resort'; 
        $rest->phone = '01907092604';
        $rest->email = 'jannat@datatrix.dev';
        $rest->address = 'Bhairab';
        $rest->instal_date = '2018-12-31';
        $rest->expiry_date = '2019-12-31';
        $rest->save();
    }
}
