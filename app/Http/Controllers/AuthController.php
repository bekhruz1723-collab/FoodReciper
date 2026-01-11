<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Вспомогательный метод для получения переводов
    private function getT() {
        $locale = session('locale', 'ru');
        $path = resource_path('translations.json');
        $json = json_decode(file_get_contents($path), true);
        return $json[$locale] ?? ($json['ru'] ?? []);
    }

    // Показать форму входа
    public function showLogin() { 
        return view('auth.login'); 
    }

    // Показать форму регистрации
    public function showRegister() { 
        return view('auth.register'); 
    }

    // Обработка регистрации
    public function register(Request $request) {
        $t = $this->getT();

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'username' => 'required|string|min:3|max:20|unique:users|regex:/^[a-zA-Z0-9._]+$/', 
            'password' => 'required|string|min:8|confirmed',
            'age' => 'nullable|integer|min:10|max:100',
        ], [
            'username.regex' => $t['val_username_regex'] ?? 'Error',
            'password.min' => $t['val_password_min'] ?? 'Error',
            'username.unique' => $t['val_username_unique'] ?? 'Error',
            'password.confirmed' => $t['val_password_confirmed'] ?? 'Error'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'age' => $data['age'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user, true);

        return redirect()->route('home');
    }

    // Обработка входа
    public function login(Request $request) {
        $t = $this->getT();

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], true)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => $t['val_login_error'] ?? 'Error',
        ])->onlyInput('username');
    }

    // Выход
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}