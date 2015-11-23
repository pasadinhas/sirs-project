<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Santos de Matos',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'id_document' => str_random(10),
            'karma' => random_int(200, 500),
            'is_admin' => true,
            'email' => 'ASM_'.str_random(5).'@gmail.com',
        ]);
    }
}
