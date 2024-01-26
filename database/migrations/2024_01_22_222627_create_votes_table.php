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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questionnaire_id');
            $table->unsignedBigInteger('vote_user_id');
            $table->unsignedBigInteger('option_id');
            $table->timestamp('created_at'); // 初回投票の時刻のみ記録

            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreign('vote_user_id')->references('id')->on('users');
            $table->foreign('option_id')->references('id')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
