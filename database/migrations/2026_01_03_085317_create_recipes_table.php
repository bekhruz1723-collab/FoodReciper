<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('recipes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description')->nullable();
        $table->integer('cooking_time'); // В минутах
        $table->string('image'); // Путь к главной картинке
        $table->json('gallery')->nullable(); // JSON массив путей доп. картинок
        $table->json('steps')->nullable(); // JSON массив шагов (текст)
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};