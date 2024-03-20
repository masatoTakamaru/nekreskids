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
        Schema::create('notices', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->string('header', 128)->nullable(false)->comment('お知らせ見出し');
            $table->text('content')->nullable(false)->comment('お知らせ本文');
            $table->date('publish_date')->nullable(false)->comment('告知日');
            $table->string('status', 16)->nullable(false)->default('public')->comment('公開状況');

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
        Schema::table('notices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};