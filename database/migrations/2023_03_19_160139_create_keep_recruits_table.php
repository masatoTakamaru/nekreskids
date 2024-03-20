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
        Schema::create('keep_recruits', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('instructor_id')->nullable(false)->comment('指導員ID');
            $table->integer('recruit_id')->nullable(false)->comment('募集ID');

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
        Schema::table('keep_recruits', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};