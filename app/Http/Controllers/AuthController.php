<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
        $data = $request->validate([
            'name' => 'required|string|max:50',
            // regex:/^[a-zA-Z0-9._]+$/ — только латиница и цифры
            'username' => 'required|string|min:3|max:20|unique:users|regex:/^[a-zA-Z0-9._]+$/', 
            'password' => 'required|string|min:8|confirmed', // confirmed требует поле password_confirmation
            'age' => 'nullable|integer|min:10|max:100',
        ], [
            'username.regex' => 'Юзернейм должен содержать только латинские буквы и цифры.',
            'password.min' => 'Пароль должен быть не менее 8 символов.',
            'username.unique' => 'Такой юзернейм уже занят.',
            'password.confirmed' => 'Пароли не совпадают.'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            // email оставляем пустым или null
            'age' => $data['age'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user, true); // Сразу входим

        return redirect()->route('home');
    }

    // Обработка входа
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Пытаемся войти по username, а не email
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], true)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Неверный юзернейм или пароль.',
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