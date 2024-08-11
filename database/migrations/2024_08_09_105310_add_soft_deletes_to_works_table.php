<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToWorksTable extends Migration
{
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropSoftDeletes();  
        });
    }
}

