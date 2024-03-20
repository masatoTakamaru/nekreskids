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
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('sender')->nullable(false)->comment('送信ユーザーID');
            $table->integer('recipient')->nullable(false)->comment('受信ユーザーID');
            $table->string('message', 512)->nullable(false)->comment('メッセージ');
            $table->integer('read_flg')->nullable(false)->comment('既読フラグ');

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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};