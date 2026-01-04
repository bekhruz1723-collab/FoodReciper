<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'recipe_id' => $recipe->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment ?? null,
        ];

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
            $data['image'] = $imagePath;
        }

        Review::create($data);

        return back()->with('success', 'Отзыв добавлен!');
    }
}