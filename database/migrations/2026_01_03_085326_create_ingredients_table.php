<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // create_ingredients_table.php
public function up(): void
{
    Schema::create('ingredients', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Уникальное название
        $table->timestamps();
    });

    Schema::create('recipe_ingredient', function (Blueprint $table) {
        $table->id();
        $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
        $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
        $table->string('amount')->nullable(); // 2 шт, 1 ложка
        $table->integer('weight')->nullable(); // Вес в граммах
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
