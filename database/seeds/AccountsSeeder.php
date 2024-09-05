<?php

use Illuminate\Database\Seeder;
use App\Account;
use Illuminate\Support\Str;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::insert([
            'name' => 'Test STW Account Access',
            'full_access' => true,
            'active' => true,
            'available_on_PC' => true,
            'external_id' => Str::uuid()
        ]);
        Account::insert([
            'name' => 'Test STW Account No Access',
            'full_access' => false,
            'active' => true,
            'available_on_PC' => true,
            'external_id' => Str::uuid()
        ]);
        Account::insert([
            'name' => 'Test BR Account Access',
            'full_access' => true,
            'active' => true,
            'available_on_PS4' => true,
            'external_id' => Str::uuid(),
            'pve' => false
        ]);
        Account::insert([
            'name' => 'Test BR Account No Access',
            'full_access' => false,
            'active' => true,
            'available_on_XBOX' => true,
            'external_id' => Str::uuid(),
            'pve' => false
        ]);

        factory(App\Account::class, 20)->create()->each(function($u) {
            $u->save();
          });

    }
}
