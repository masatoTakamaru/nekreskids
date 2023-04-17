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
        Schema::create('applications', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('recruit_id')->nullable(false)->comment('募集ID');
            $table->integer('instructor_id')->nullable(false)->comment('指導員ID');
            $table->string('message', 512)->nullable()->comment('メッセージ');
            $table->integer('del_flg')->nullable(false);


            $table->softDeletes();
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
        Schema::table('applications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};