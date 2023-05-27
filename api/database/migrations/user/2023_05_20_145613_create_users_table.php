<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'users';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('user_id');

            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
