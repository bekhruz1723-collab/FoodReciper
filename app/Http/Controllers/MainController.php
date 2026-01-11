<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function home() {
        $recipes = Recipe::with('user')->latest()->get();
        return view('home', compact('recipes'));
    }

    public function changeLocale($lang) {
        if (in_array($lang, ['ru', 'en', 'uz'])) {
            Session::put('locale', $lang);
        }
        return back();
    }
}