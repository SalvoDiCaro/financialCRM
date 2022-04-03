<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class CreateProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create(['name' => 'Mutuo']);
        Product::create(['name' => 'Prestiti personali']);
        Product::create(['name' => 'Cessione del quinto']);
        Product::create(['name' => 'Leasing']);
        Product::create(['name' => 'Factoring']);
        Product::create(['name' => 'Aziende affidate']);
        Product::create(['name' => 'Aziende non affidate']);
        Product::create(['name' => 'Cliente privato']);

    }
}
