<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->integer('recruit_id')->nullable(false)->comment('募集ID');
            $table->integer('instructor_id')->nullable(false)->comment('指導員ID');
            $table->string('message', 512)->nullable()->comment('メッセージ');

            $table->softDeletes('deleted_at', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('flights');
    }
};
