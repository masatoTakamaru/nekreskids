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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('user_id')->nullable(false)->comment('登録者名');
            $table->string('name', 128)->nullable(false)->comment('名前');
            $table->string('name_kana', 128)->nullable(false)->comment('名前カナ');
            $table->string('avatar_url', 255)->nullable()->default('no-image.png')->comment('アバター画像URL');
            $table->text('pr')->nullable()->comment('自己紹介');
            $table->text('activities')->nullable()->comment('指導できる活動');
            $table->string('other_activities', 255)->nullable()->comment('指導できる活動（その他）');
            $table->string('ontime', 255)->nullable()->comment('指導できる曜日や時間帯');
            $table->text('act_areas')->nullable()->comment('指導できる都道府県市区町村');
            $table->date('birth')->nullable(false)->comment('生年月日');
            $table->string('cert', 255)->nullable()->comment('所有資格');
            $table->string('gender', 128)->nullable(false)->comment('性別');
            $table->integer('zip')->nullable(false)->comment('郵便番号');
            $table->string('pref', 255)->nullable(false)->comment('都道府県');
            $table->string('city', 255)->nullable(false)->comment('市区町村');
            $table->string('address', 255)->nullable(false)->comment('町域・番地・建物名など');
            $table->string('tel', 20)->nullable()->comment('電話番号');
            $table->integer('keep')->nullable()->comment('気になるリスト登録数');

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
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};