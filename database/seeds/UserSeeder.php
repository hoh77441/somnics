<?php
use Illuminate\Database\Seeder;

use App\Model\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            User::ID => 1,
            User::NAME => 'admin1',
            User::EMAIL => 'admin1',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 2,
            User::NAME => 'employee1',
            User::EMAIL => 'employee1',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 3,
            User::NAME => 'agent1',
            User::EMAIL => 'agent1',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 4,
            User::NAME => 'agent2',
            User::EMAIL => 'agent2',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 5,
            User::NAME => 'hospital1',
            User::EMAIL => 'hospital1',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 6,
            User::NAME => 'care1',
            User::EMAIL => 'care1',
            User::PASSWORD => '25181598',
        ]);
        
        User::create([
            User::ID => 7,
            User::NAME => 'HELEN',
            User::EMAIL => 'HELEN',
            User::PASSWORD => 'artemis1214',
        ]);
        
        User::create([
            User::ID => 8,
            User::NAME => 'MAXIS',
            User::EMAIL => 'MAXIS',
            User::PASSWORD => 'operation',
        ]);
        
        User::create([
            User::ID => 9,
            User::NAME => 'GD',
            User::EMAIL => 'GD',
            User::PASSWORD => '1111',
        ]);
        
        User::create([
            User::ID => 10,
            User::NAME => 'MUSLUM',
            User::EMAIL => 'MUSLUM',
            User::PASSWORD => 'operation',
        ]);
    }
}
