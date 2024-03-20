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
        Schema::create('school_scores', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('school_id')->nullable(false)->comment('学校ID');
            $table->integer('instructor_id')->nullable(false)->comment('指導員ID');
            $table->integer('score')->nullable()->comment('評価点');

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
        Schema::table('school_scores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};