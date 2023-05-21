<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName = 'categories';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id('category_id');

            $table->string('name', 255);
            $table->string('formal_name', 255);
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName);
    }
};
