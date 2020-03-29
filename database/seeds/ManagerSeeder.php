<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('user'),
        ]);
        DB::table('users')->insert([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('manager'),
            'is_manager' => true,
        ]);
        DB::table('categories')->insert([
            'name' => 'DefaultCategory',
        ]);
    }
}
