<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Fantastik',
            'epic_id' => 'FantastikN',
            'discord_id' => 'Fantastik#6777',
            'platform' => 'PC',
            'email' => 'email@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
