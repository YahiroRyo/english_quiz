<?php

use Eng\Quiz\Domain\Entity\QuizConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName     = 'quizzes';
    private string $addColumnName = 'speech_answer_url';

    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string($this->addColumnName, 2048)->after('answer')->default(QuizConstants::DEFAULT_QUIZ_SPEECH_ANSWER_URL);
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn($this->addColumnName);
        });
    }
};
