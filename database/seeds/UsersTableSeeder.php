<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'jeyziel',
            'email' => 'admin@users.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'fulano',
            'email' => 'usuario@users.com',
            'password' => bcrypt('123456'),
        ]);

    }
}
