<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class WorkSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('works')->insert([
        'id'=>'1',
        'user_id' => '1',
        'title' => 'workstest1',
        'description'=>'description for workstest1',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        'is_public'=>'1'
        ]);
        DB::table('works')->insert([
        'id'=>'2',
        'user_id' => '1',
        'title' => 'workstest2',
        'description'=>'description for workstest2',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        'is_public'=>'0'
        ]);
        DB::table('works')->insert([
        'id'=>'3',
        'user_id' => '2',
        'title' => 'workstest3',
        'description'=>'description for workstest3',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        'is_public'=>'0'
        ]);
    }
}
