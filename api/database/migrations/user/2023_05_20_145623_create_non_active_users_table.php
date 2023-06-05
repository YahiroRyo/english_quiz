<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'non_active_users';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->foreignId('user_id')->primary();

            $table->string('personality', 512);
            $table->string('name', 60);
            $table->string('icon', 2048);
            $table->timestamps();

            // $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
