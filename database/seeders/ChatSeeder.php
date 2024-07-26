<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;


class ChatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chats')->insert([
        'id'=>'1',
        'work_id' => '1',
        'is_user' => '1',
        'message'=>'first question for work1',
        'created_at' => new DateTime(),
        ]);
        DB::table('chats')->insert([
        'id'=>'2',
        'work_id' => '1',
        'is_user' => '0',
        'message'=>'first answer for work1',
        'created_at' => new DateTime(),
        ]);
        
        DB::table('chats')->insert([
        'id'=>'3',    
        'work_id' => '2',
        'is_user' => '1',
        'message'=>'first question for work2',
        'created_at' => new DateTime(),
        ]);
        DB::table('chats')->insert([
        'id'=>'4',
        'work_id' => '2',
        'is_user' => '0',
        'message'=>'first answer for work2',
        'created_at' => new DateTime(),
        ]);
        
        DB::table('chats')->insert([
        'id'=>'5',
        'work_id' => '3',
        'is_user' => '1',
        'message'=>'first question for work3',
        'created_at' => new DateTime(),
        ]);
        DB::table('chats')->insert([
        'id'=>'6',
        'work_id' => '3',
        'is_user' => '0',
        'message'=>'first answer for work3',
        'created_at' => new DateTime(),
        ]);
        DB::table('chats')->insert([
        'id'=>'7',
        'work_id' => '3',
        'is_user' => '1',
        'message'=>'second question for work3',
        'created_at' => new DateTime(),
        ]);
        DB::table('chats')->insert([
        'id'=>'8',
        'work_id' => '3',
        'is_user' => '0',
        'message'=>'second answer for work3',
        'created_at' => new DateTime(),
        ]);
    }
}
