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
        Schema::create('report',function (Blueprint $table){
            $table->unsignedInteger('reportID')->primary();
            $table->unsignedInteger('userID');
            $table->unsignedInteger('imgID');
            $table->string('Prediction');
            $table->dateTime('ResTime');
            $table->string('Description');
        });

        Schema::table('report',function(Blueprint $table){
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('imgID')->references('imgID')->on('Images')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report');
    }
};
