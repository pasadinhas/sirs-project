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

        User::create([
            'name' => 'Admin Santos de Matos',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_admin' => true,
            'email' => 'ASM_'.str_random(5).'@gmail.com',
        ]);

        Model::reguard();
    }
}
