<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_test_supplier = new Role();
        $role_test_supplier->name = 'Test Supplier';
        $role_test_supplier->description = 'Item supplier with a revenue of 10%';
        $role_test_supplier->save();

        $role_supplier = new Role();
        $role_supplier->name = 'Supplier';
        $role_supplier->description = 'Item supplier with a revenue of 15%';
        $role_supplier->save();

        $role_contributor = new Role();
        $role_contributor->name = 'Contributor';
        $role_contributor->description = 'Influencer';
        $role_contributor->save();

        $role_distributor = new Role();
        $role_distributor->name = 'Distributor';
        $role_distributor->description = 'Item supplier for the website.';
        $role_distributor->save();

        $role_recruiter = new Role();
        $role_recruiter->name = 'Recruiter';
        $role_recruiter->description = 'Recruit clients to the website';
        $role_recruiter->save();
    }
}
