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
        $user = User::create([
            'name' => 'Hector Villarreal',
            'email' => 'hectorviov@gmail.com',
            'username' => 'hectorviov',
            'twitter_handle' => 'hectorviov',
            'password' => Hash::make('changeme'),
        ]);

        $user = User::create([
            'name' => 'Marques Brownlee',
            'email' => 'mkbhd@gmail.com',
            'username' => 'mkbhd',
            'twitter_handle' => 'mkbhd',
            'password' => Hash::make('changeme'),
        ]);

        $user = User::create([
            'name' => 'Bill Gates',
            'email' => 'billgates@outlook.com',
            'username' => 'BillGates',
            'twitter_handle' => 'BillGates',
            'password' => Hash::make('changeme'),
        ]);
    }
}
