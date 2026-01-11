<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ing1 = Ingredient::firstOrCreate(['name' => 'Курица']);
        $ing2 = Ingredient::firstOrCreate(['name' => 'Картофель']);
        $ing3 = Ingredient::firstOrCreate(['name' => 'Сыр']);

        // Админ
        $admin = User::create([
            'name' => 'Шеф Администратор',
            'username' => 'admin', // Латиница!
            'age' => 30,
            'password' => Hash::make('password123'), // Пароль > 8 символов
            'bio' => 'Создатель FoodReciper.',
        ]);

        // Обычный юзер
        $user2 = User::create([
            'name' => 'Мария Вкусная',
            'username' => 'maria_cook',
            'age' => 28,
            'password' => Hash::make('password123'),
            'bio' => 'Люблю печь пироги.',
        ]);

        $recipe1 = Recipe::create([
            'user_id' => $admin->id,
            'title' => 'Сливочная курица',
            'description' => 'Нежнейшее филе в сливочном соусе.',
            'instructions' => "1. Обжарить курицу.\n2. Добавить сливки.\n3. Тушить 20 минут.",
            'cooking_time' => 30,
            // Длинный текст для картинки теперь поддерживается (longText)
            'image' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=1000&auto=format&fit=crop',
        ]);

        $recipe1->ingredients()->attach([
            $ing1->id => ['amount' => '500 г'],
            $ing3->id => ['amount' => '200 г'],
        ]);
        
        Review::create([
            'user_id' => $user2->id,
            'recipe_id' => $recipe1->id,
            'rating' => 5,
            'comment' => 'Очень вкусно и быстро!',
        ]);
    }
}