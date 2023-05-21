<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'quizes';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('quiz_id');

            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->text('prompt');
            $table->text('question');
            $table->timestamp('created_at');

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
