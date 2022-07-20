<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 0,
            'username' => 'Anonymous',
            'lastName' => '',
            'displayname' => 'Anonymous',
            'email' => 'anonymous',
            'password' => Hash::make('anonymous'),
            'avatar' => '',
            'admin' => false,
            'verified' => true,
            'registered' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'admin',
            'lastName' => '',
            'displayname' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'avatar' => 'admin.jpg',
            'admin' => true,
            'verified' => true,
            'registered' => now(),
        ]);

       
    }
}
