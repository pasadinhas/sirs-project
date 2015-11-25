<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
            'name' => 'Admin Santos de Matos',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_admin' => true,
            'email' => 'ASM_'.str_random(5).'@gmail.com',
        ]);

        User::create([
            'name' => 'Manuel "Má Onda" Meco',
            'username' => 'driver',
            'password' => bcrypt('driver'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_driver' => true,
            'email' => 'MM_'.str_random(5).'@gmail.com',
        ]);
        Model::reguard();
    }
}
