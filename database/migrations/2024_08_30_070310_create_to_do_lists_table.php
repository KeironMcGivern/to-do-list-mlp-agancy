<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('to_do_lists', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('guid', 36);
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }
};
