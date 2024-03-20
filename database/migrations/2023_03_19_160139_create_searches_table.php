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
        Schema::create('searches', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('instructor_id')->nullable(false)->comment('指導員ID');
            $table->integer('recruit_id')->nullable(false)->comment('募集ID');
            $table->integer('del_flg')->nullable(false);

            $table->softDeletes('deleted_at', precision: 0);
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
        Schema::table('searches', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};