<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_category = new ProductCategory();
        $product_category->restaurant_id = 1;
        $product_category->name = 'Breakfast';
        $product_category->save();
    }
}
