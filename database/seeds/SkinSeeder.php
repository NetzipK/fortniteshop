<?php

use Illuminate\Database\Seeder;
use App\Skin;
use Illuminate\Support\Str;

class SkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skin::insert([
            'name' => 'Test Skin #1',
            'external_id' => Str::uuid()
        ]);
        Skin::insert([
            'name' => 'Test Skin #2',
            'external_id' => Str::uuid()
        ]);
        Skin::insert([
            'name' => 'Test Skin #3',
            'external_id' => Str::uuid()
        ]);
        Skin::insert([
            'name' => 'Test Skin #4',
            'external_id' => Str::uuid()
        ]);
    }
}
