<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function create() {
        return view('recipes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'cooking_time' => 'required|integer|min:1',
            'image' => 'required|image|max:5000', // Макс 5Мб
            'gallery.*' => 'image|max:5000',
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string', // Название обязательно
        ]);

        // 1. Загрузка главной картинки
        $imagePath = $request->file('image')->store('recipes', 'public');

        // 2. Загрузка галереи
        $galleryPaths = [];
        if($request->hasFile('gallery')) {
            foreach($request->file('gallery') as $photo) {
                $galleryPaths[] = $photo->store('recipes', 'public');
            }
        }

        // 3. Создание рецепта
        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'cooking_time' => $request->cooking_time,
            'image' => $imagePath,
            'gallery' => $galleryPaths, // Laravel сам преобразует array в json (через casts)
            'steps' => array_values(array_filter($request->steps ?? [])), // Очищаем пустые шаги
        ]);

        // 4. Обработка ингредиентов
        foreach ($request->ingredients as $ingData) {
            if (!empty($ingData['name'])) {
                // Находим или создаем ингредиент в общей базе (для поиска)
                $ingredient = Ingredient::firstOrCreate(['name' => mb_strtolower(trim($ingData['name']))]);

                // Привязываем к рецепту
                $recipe->ingredients()->attach($ingredient->id, [
                    'amount' => $ingData['amount'] ?? null,
                    'weight' => $ingData['weight'] ?? null,
                ]);
            }
        }

        return redirect()->route('home');
    }

    public function show(Recipe $recipe) {
        $recipe->load(['ingredients', 'user']);
        return view('recipes.show', compact('recipe'));
    }
}