<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Giuseppe Rapisarda',
            'email' => 'GRAPISARDA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3333333333',
            'agent_code' => '00000000',
            'assignable' => false,
            'password' => bcrypt('Rapisarda2021')
        ]);

        User::create([
            'name' => 'SEGRETERIA',
            'email' => 'BACKOFFICE@AVVERAMUTUISICILIA.IT',
            'phone' => '3333333333',
            'agent_code' => '00000000',
            'assignable' => false,
            'password' => bcrypt('Backoffice2021')
        ]);

    }
}
