<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Projecthours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projecthour', function (Blueprint $table) {
           $table->dateTime('publish_date')->nullable();
		   $table->dateTime('publishdate_end')->nullable();
		   $table->integer('isactive')->unsigned();
		   $table->float('hours', 8, 2)->nullable();
		   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projecthour', function (Blueprint $table) {
            $table->dropColumn('publish_date');
			$table->dropColumn('publishdate_end');
			$table->dropColumn('isactive');
			$table->dropColumn('hours');
        });
    }
}
