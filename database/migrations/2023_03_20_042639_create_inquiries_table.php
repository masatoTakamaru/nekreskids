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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->string('email', 255)->nullable(false)->comment('メールアドレス');
            $table->text('message')->nullable(false)->comment('内容');

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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};