<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'answers';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->foreignId('quiz_id')->primary();

            $table->text('answer');
            $table->text('reply');
            $table->boolean('is_correct');
            $table->timestamp('created_at');

            $table->foreign('quiz_id')->references('quiz_id')->on('quizes');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
