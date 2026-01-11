@extends('layout')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white p-10 rounded-3xl shadow-soft border border-stone-100">
        <h1 class="text-3xl font-bold text-center mb-2 text-dark">{{ $t['welcome_title'] }}</h1>
        <p class="text-center text-stone-500 mb-8">{{ $t['create_profile_subtitle'] }}</p>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">{{ $t['your_name'] }}</label>
                <input type="text" name="name" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="{{ $t['placeholder_name'] }}" required value="{{ old('name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">{{ $t['username_latin'] }}</label>
                <input type="text" name="username" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="{{ $t['placeholder_username'] }}" required value="{{ old('username') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">{{ $t['age'] }}</label>
                    <input type="number" name="age" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="25" value="{{ old('age') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">{{ $t['password_min_8'] }}</label>
                <input type="password" name="password" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="••••••••" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">{{ $t['repeat_password'] }}</label>
                <input type="password" name="password_confirmation" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="••••••••" required>
            </div>
            
            <button class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-primaryHover transition shadow-lg shadow-emerald-100 mt-4">
                {{ $t['create_account_btn'] }}
            </button>
        </form>
        
        <p class="text-center mt-6 text-stone-500 text-sm">
            {{ $t['already_have_account'] }} <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">{{ $t['login'] }}</a>
        </p>
    </div>
</div>
@endsection