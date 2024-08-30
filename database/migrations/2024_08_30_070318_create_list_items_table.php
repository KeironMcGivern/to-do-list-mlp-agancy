<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('guid', 36);
            $table->bigInteger('list_id')->unsigned();
            $table->text('content');
            $table->boolean('completed');
            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::table('list_items', function (Blueprint $table) {
            $table->foreign('list_id')->references('id')->on('to_do_lists');
        });
    }
};
