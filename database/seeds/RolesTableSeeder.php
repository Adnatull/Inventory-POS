<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::table('role_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Role::create(['name'=> 'admin']);
        Role::create(['name'=> 'manager']);
        Role::create(['name'=> 'executive']);
        Role::create(['name'=> 'seller']);
        Role::create(['name'=> 'buyer']);
    }
}
