<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'quiz_responses';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->foreignId('quiz_id')->primary();

            $table->text('answer');
            $table->foreignId('quiz_response_reply_id');
            $table->boolean('is_correct');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes');
            $table->foreign('quiz_response_reply_id')->references('quiz_response_reply_id')->on('quiz_response_replies');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
