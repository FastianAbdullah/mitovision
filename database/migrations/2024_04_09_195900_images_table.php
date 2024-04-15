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
        Schema::create('Images',function(Blueprint $table){
            $table->unsignedInteger('imgID')->primary();
            $table->string('imgurl')->nullable(false);
            $table->unsignedInteger('userID');
           // $table->foreign('userID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('PatientID')->nullable(false);
            $table->string('PatientName');
        });

        //Defining foreign key contraints
        Schema::table('Images',function(Blueprint $table){
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Images');
    }
};
