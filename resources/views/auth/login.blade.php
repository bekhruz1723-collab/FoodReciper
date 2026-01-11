@extends('layout')

@section('content')
<div class="max-w-md mx-auto mt-16">
    <div class="bg-white p-10 rounded-3xl shadow-soft border border-stone-100">
        <h1 class="text-3xl font-bold text-center mb-8 text-dark">{{ $t['login'] }}</h1>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">{{ explode(' (', $t['username_latin'])[0] }}</label>
                <input type="text" name="username" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="{{ $t['placeholder_username'] }}" required value="{{ old('username') }}">
            </div>

            <div>
                 <label class="block text-sm font-medium text-stone-700 mb-1">{{ explode(' (', $t['password_min_8'])[0] }}</label>
                <input type="password" name="password" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="••••••••" required>
            </div>
            
            <button class="w-full bg-dark text-white py-4 rounded-xl font-bold hover:bg-stone-800 transition shadow-lg shadow-stone-200 mt-2">
                {{ $t['login'] }}
            </button>
        </form>
        <p class="text-center mt-6 text-stone-500 text-sm">
            {{ $t['first_time_question'] }} <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">{{ $t['register'] }}</a>
        </p>
    </div>
</div>
@endsection