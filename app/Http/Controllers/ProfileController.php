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
    private function getT() {
        $locale = session('locale', 'ru');
        $path = resource_path('translations.json');
        $json = json_decode(file_get_contents($path), true);
        return $json[$locale] ?? ($json['ru'] ?? []);
    }

    public function show($username) {
        $user = User::where('username', $username)->firstOrFail();
        $recipes = Recipe::where('user_id', $user->id)->latest()->get();
        return view('profile.show', compact('user', 'recipes'));
    }

    public function edit() {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request) {
        $user = Auth::user();
        $t = $this->getT();

        $request->validate([
            'name' => 'required|string|max:50',
            'avatar' => 'nullable|image|max:2048',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->age = $request->age;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => $t['val_old_password_error'] ?? 'Error']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();
        return redirect()->route('profile.show', $user->username);
    }
}