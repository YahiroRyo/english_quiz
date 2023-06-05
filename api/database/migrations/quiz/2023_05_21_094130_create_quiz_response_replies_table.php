<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'quiz_response_replies';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('quiz_response_reply_id');

            $table->foreignId('quiz_response_id');
            $table->string('role', 255);
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();

            // $table->foreign('quiz_response_id')->references('quiz_response_id')->on('quiz_responses');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
