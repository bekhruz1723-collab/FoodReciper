<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', 'ru');
        $path = resource_path('translations.json');
        
        $translations = [];
        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);
            $translations = $json[$locale] ?? ($json['ru'] ?? []);
        }

        if (empty($translations)) {
            $translations = ['welcome' => 'Welcome (Default)'];
        }

        View::share('t', $translations);
        View::share('current_locale', $locale);

        return $next($request);
    }
}