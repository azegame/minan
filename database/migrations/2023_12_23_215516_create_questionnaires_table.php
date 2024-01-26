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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id(); // ユニークなID
            $table->unsignedBigInteger('user_id');
            $table->string('questionnaire_name');
            $table->boolean('public_flag');
            $table->boolean('vote_flag');
            $table->timestamps(); // 作成日と更新日

            // ユーザーテーブルとの外部キー制約
            $table->foreign('user_id')->references('id')->on('users');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
