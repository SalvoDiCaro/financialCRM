<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spot;

class CreateSpotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spot::create([
            'id' => 6,
            'name' => 'Salina',
            'places_available' => 1,
            'type' => 'Sala consulenza',
        ]);
        Spot::create([
            'id' => 5,
            'name' => 'Panarea',
            'places_available' => 1,
            'type' => 'Sala riunioni',
        ]);
        Spot::create([
            'id' => 4,
            'name' => 'Lipari',
            'places_available' => 4,
            'type' => 'Postazione',
        ]);
        Spot::create([
            'id' => 3,
            'name' => 'Vulcano',
            'places_available' => 1,
            'type' => 'Postazione',
        ]);
        Spot::create([
            'id' => 2,
            'name' => 'Stromboli',
            'places_available' => 1,
            'type' => 'Sala riunioni',
        ]);
        Spot::create([
            'id' => 1,
            'name' => 'Lampedusa',
            'places_available' => 1,
            'type' => 'Sala consulenza',
        ]);
    }
}
