<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'alawa',
            'email' => 'alawa@gmail.com',
            'type' => 'admin',
            'type' => 'admin',
            'photo'  =>'profile.png',
            'solde'=> 0,
            'password' => Hash::make('adminadmin'),
        ]);
    }
}
