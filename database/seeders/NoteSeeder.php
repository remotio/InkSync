<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notes')->insert([
        'id'=>'1',
        'work_id' => '1',
        'html_path' => null,
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
        DB::table('notes')->insert([
        'id'=>'2',
        'work_id' => '2',
        'html_path' => null,
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
        DB::table('notes')->insert([
        'id'=>'3',
        'work_id' => '3',
        'html_path' => null,
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
    }
}
