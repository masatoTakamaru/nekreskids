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
        Schema::create('schools', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->string('name', 128)->nullable(false)->comment('学校名');
            $table->integer('zip')->nullable(false)->comment('郵便番号');
            $table->string('pref', 128)->nullable(false)->comment('都道府県');
            $table->string('city', 128)->nullable(false)->comment('市区町村');
            $table->string('address', 128)->nullable(false)->comment('町域・番地・建物名など');
            $table->string('tel1', 20)->nullable(false)->comment('電話番号１');
            $table->string('tel2', 20)->nullable()->comment('電話番号２');
            $table->string('charge', 128)->nullable(false)->comment('担当者名');
            $table->float('score', 2, 1)->nullable(false)->comment('評価点');

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
        Schema::table('schools', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
