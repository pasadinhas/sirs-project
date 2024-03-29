<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Shuttle\Shuttle;
use Shuttle\Trip;
use Shuttle\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        User::truncate();

        User::create([
            'name' => 'David Matos',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_admin' => true,
            'email' => 'ASM_'.str_random(5).'@gmail.com',
        ]);

        User::create([
            'name' => 'Manuel Pereira',
            'username' => 'driver',
            'password' => bcrypt('driver'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_driver' => true,
            'email' => 'MM_'.str_random(5).'@gmail.com',
        ]);

        Shuttle::truncate();

        Shuttle::create([
            'name' => 'S01',
            'seats' => 42,
            'key' => 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'
        ]);

        Trip::create([
            'shuttle_id' => 1,
            'driver_id' => 2,
            'origin' => 'Evora',
            'destination' => 'Lisboa',
            'leaves_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(10,45)),
            'arrives_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(120,180)),
        ]);

        Trip::create([
            'shuttle_id' => 1,
            'driver_id' => 2,
            'origin' => 'Alameda',
            'destination' => 'Tagus',
            'leaves_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(60,90)),
            'arrives_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(190,280)),
        ]);

        Trip::create([
            'shuttle_id' => 1,
            'driver_id' => 2,
            'origin' => 'Porto',
            'destination' => 'Coimbra',
            'leaves_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(120,180)),
            'arrives_at' => \Carbon\Carbon::now()->addMinutes(mt_rand(300,400)),
        ]);

        Model::reguard();
    }
}
