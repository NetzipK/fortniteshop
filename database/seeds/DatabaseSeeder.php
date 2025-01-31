<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AccountsSeeder::class);
         $this->call(SkinSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(ArticleSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(RoleTableSeeder::class);
    }
}
