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
        Schema::table('pricing', function (Blueprint $table) {
          //  $table->dropColumn('StartDate');
           // $table->dropColumn('EndDate');           
           // $table->dateTime('StartDate')->nullable()->change();
           // $table->dateTime('EndDate')->nullable()->change();
           $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pricing', function (Blueprint $table) {
            $table->dropColumn('StartDate');
            $table->dropColumn('EndDate');
        });
    }
};
