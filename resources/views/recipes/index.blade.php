@extends('layout')

@section('content')
    <div class="bg-white p-6 rounded-3xl shadow-sm mb-8 border border-stone-100">
        <h2 class="text-xl font-bold text-dark mb-4">🔍 Что будем готовить?</h2>
        <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <div>
                <label class="block text-sm text-stone-500 mb-1">Содержит:</label>
                <select name="include_ing" class="w-full p-2 bg-secondary rounded-xl border-none focus:ring-2 focus:ring-primary">
                    <option value="">Любой продукт</option>
                    @foreach($ingredients as $ing)
                        <option value="{{ $ing->id }}" {{ request('include_ing') == $ing->id ? 'selected' : '' }}>{{ $ing->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-red-400 mb-1">Без продукта (аллергия):</label>
                <select name="exclude_ing" class="w-full p-2 bg-red-50 rounded-xl border-none focus:ring-2 focus:ring-red-400">
                    <option value="">Ничего не исключать</option>
                    @foreach($ingredients as $ing)
                        <option value="{{ $ing->id }}" {{ request('exclude_ing') == $ing->id ? 'selected' : '' }}>{{ $ing->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-stone-500 mb-1">Сортировка:</label>
                <select name="sort" class="w-full p-2 bg-secondary rounded-xl border-none">
                    <option value="new">🆕 Сначала новые</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>⭐ Популярные</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-dark text-white p-2 rounded-xl hover:bg-stone-700 transition">Применить</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="group block bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="{{ $recipe->image ?? 'https://via.placeholder.com/400x300?text=No+Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-2 right-2 bg-white px-2 py-1 rounded-lg text-xs font-bold shadow">
                        ⏱ {{ $recipe->cooking_time }} мин
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-lg text-dark leading-tight">{{ $recipe->title }}</h3>
                        <div class="flex items-center text-primary text-sm font-bold">
                            ★ {{ $recipe->average_rating }}
                        </div>
                    </div>
                    <p class="text-stone-500 text-sm line-clamp-2 mb-3">{{ $recipe->description }}</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($recipe->ingredients->take(3) as $ing)
                            <span class="text-xs bg-secondary text-stone-600 px-2 py-1 rounded-md">{{ $ing->name }}</span>
                        @endforeach
                        @if($recipe->ingredients->count() > 3)
                            <span class="text-xs text-stone-400">+ ещё</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection