@extends('layout')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white p-10 rounded-3xl shadow-soft border border-stone-100">
        <h1 class="text-3xl font-bold text-center mb-2 text-dark">Добро пожаловать</h1>
        <p class="text-center text-stone-500 mb-8">Создайте профиль в FoodReciper</p>

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
                <label class="block text-sm font-medium text-stone-700 mb-1">Ваше имя</label>
                <input type="text" name="name" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="Иван Петров" required value="{{ old('name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Юзернейм (только латиница)</label>
                <input type="text" name="username" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="chef_ivan" required value="{{ old('username') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Возраст</label>
                    <input type="number" name="age" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="25" value="{{ old('age') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Пароль (мин. 8 символов)</label>
                <input type="password" name="password" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="••••••••" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Повторите пароль</label>
                <input type="password" name="password_confirmation" class="w-full p-3 rounded-xl bg-stone-50 border-none focus:ring-2 focus:ring-primary transition" placeholder="••••••••" required>
            </div>
            
            <button class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-primaryHover transition shadow-lg shadow-emerald-100 mt-4">
                Создать аккаунт
            </button>
        </form>
        
        <p class="text-center mt-6 text-stone-500 text-sm">
            Уже есть аккаунт? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Войти</a>
        </p>
    </div>
</div>
@endsection