<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('username')->unique();
        $table->string('email')->nullable();
        $table->string('password');
        $table->integer('age')->nullable();
        $table->text('bio')->nullable();
        $table->string('avatar')->nullable(); // Путь к файлу аватара
        $table->rememberToken();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};