<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Автоматически преобразуем JSON из базы в массив PHP
    protected $casts = [
        'gallery' => 'array',
        'steps' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
                    ->withPivot('amount', 'weight');
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);
    }
}