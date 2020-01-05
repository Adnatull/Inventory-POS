<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $executiveRole = Role::where('name', 'executive')->first();
        $sellerRole = Role::where('name', 'seller')->first();
        $buyerRole = Role::where('name', 'buyer')->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin@admin.com')
        ]);

        $admin->roles()->attach($adminRole->id);
        $admin->roles()->attach($managerRole->id);
        $admin->roles()->attach($executiveRole->id);
        $admin->roles()->attach($sellerRole->id);
        $admin->roles()->attach($buyerRole->id);
    }
}
