<?php

use Eng\Chatgpt\Domain\Entity\ChatConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName     = 'quiz_response_replies';
    private string $addColumnName = 'function_name';

    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string($this->addColumnName, 255)->after('message')->default(ChatConstants::DEFAULT_FUNCTION_NAME);
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn($this->addColumnName);
        });
    }
};
