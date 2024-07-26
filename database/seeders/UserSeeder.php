<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
        'id'=>'1',
        'name' => 'seedertest1',
        'email' => 'seedertest1@gmail.com',
        'email_verified_at'=>new DateTime(),
        'password'=>Hash::make('seedertest1'),
        'remember_Token'=>'seedertest1',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
        'id'=>'2',
        'name' => 'seedertest2',
        'email' => 'seedertest2@gmail.com',
        'email_verified_at'=>new DateTime(),
        'password'=>Hash::make('seedertest2'),
        'remember_Token'=>'seedertest2',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
    }
}
