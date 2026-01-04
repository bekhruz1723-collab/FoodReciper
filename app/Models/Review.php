<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'recipe_id', 'rating', 'comment', 'image'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}