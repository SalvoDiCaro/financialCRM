<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class CreateAgentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = ([
            'name' => 'SIMONA ECORA',
            'email' => 'SECORA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3933538075',
            'agent_code' => '14345678',
            'assignable' => true,
            'password' => bcrypt('Ecora2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'ANDREA SCANDURA',
            'email' => 'ASCADURA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3336585452',
            'agent_code' => '75842695',
            'assignable' => true,
            'password' => bcrypt('Scandura2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'PIERO CAVARRA',
            'email' => 'PCAVARRA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Cavarra2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'ALESSIA STRANO',
            'email' => 'ASTRANO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Strano2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'SIMONA GRECO',
            'email' => 'SGRECO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Greco2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'ROBERTA ACUNTO',
            'email' => 'RACUNTO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Acunto2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'RICCARDO FAMA',
            'email' => 'RFAMA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Fama2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'GIUSY PULITANO',
            'email' => 'GPULITANO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Pulitano2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'CRISTINA CAVALLO',
            'email' => 'MCAVALLO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Cavallo2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'CHIARA CURATOLO',
            'email' => 'CCURATOLO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Curatolo2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'FABRIZIO MONTALTO',
            'email' => 'FMONTALTO@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Montalto2021'),
        ]);

        User::create($input);

        $input = ([
            'name' => 'SALVATORE LICITRA',
            'email' => 'SLICITRA@AVVERAFINANZIAMENTI.IT',
            'phone' => '3334569875',
            'agent_code' => '32541285',
            'assignable' => true,
            'password' => bcrypt('Licitra2021'),
        ]);

        User::create($input);

    }
}
