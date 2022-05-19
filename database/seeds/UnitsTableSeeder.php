<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $unit = new Unit();
        $unit->restaurant_id = 1;
        $unit->name = 'Piece';
        $unit->shortname = 'PCS';
        $unit->save();
    }
}
