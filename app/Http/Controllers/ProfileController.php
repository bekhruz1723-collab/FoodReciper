<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Просмотр любого профиля
    public function show($username) {
        $user = User::where('username', $username)->firstOrFail();
        $recipes = Recipe::where('user_id', $user->id)->latest()->get();
        return view('profile.show', compact('user', 'recipes'));
    }

    // Страница редактирования
    public function edit() {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Сохранение изменений
    public function update(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:50',
            'avatar' => 'nullable|image|max:2048',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Смена имени/возраста/био
        $user->name = $request->name;
        $user->age = $request->age;
        $user->bio = $request->bio;

        // Аватар
        if ($request->hasFile('avatar')) {
            // Удаляем старый если был (кроме дефолтного)
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Смена пароля
        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Старый пароль неверен']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();
        return redirect()->route('profile.show', $user->username);
    }
}