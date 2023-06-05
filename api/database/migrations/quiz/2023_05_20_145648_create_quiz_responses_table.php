<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'quiz_responses';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('quiz_response_id');

            $table->foreignId('quiz_id');
            $table->text('answer');
            $table->boolean('is_correct');
            $table->timestamp('created_at')->useCurrent();

            // $table->foreign('quiz_id')->references('quiz_id')->on('quizzes');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
