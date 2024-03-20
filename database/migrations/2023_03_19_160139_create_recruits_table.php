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
        Schema::create('recruits', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('school_id')->nullable(false)->comment('学校ID');
            $table->string('header', 128)->nullable(false)->comment('件名');
            $table->text('pr')->nullable()->comment('紹介文');
            $table->string('recruit_type', 16)->nullable(false)->comment('募集種別');
            $table->text('activities')->nullable(false)->comment('募集する活動');
            $table->string('other_activities', 128)->nullable()->comment('募集する活動（その他）');
            $table->string('ontime', 128)->nullable(false)->comment('募集する日時');
            $table->string('payment_type', 16)->nullable(false)->comment('支払い種別');
            $table->integer('payment')->nullable()->comment('給与額（円）');
            $table->string('commutation_type')->nullable(false)->comment('交通費の支給');
            $table->integer('commutation')->nullable()->comment('交通費（円）');
            $table->integer('number')->nullable(false)->comment('募集人数（人）');
            $table->string('status', 16)->nullable(false)->default('public')->comment('公開状況');
            $table->date('end_date')->nullable(false)->comment('募集期限日');
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
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};