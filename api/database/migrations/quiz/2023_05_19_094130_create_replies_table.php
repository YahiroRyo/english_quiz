<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'replies';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('reply_id');

            $table->text('message');
            $table->foreignId('response_id')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
