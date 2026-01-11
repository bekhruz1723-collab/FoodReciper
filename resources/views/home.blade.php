@extends('layout')

@section('content')
<div class="space-y-12">
    <div class="relative rounded-[2rem] overflow-hidden bg-dark py-20 px-10 text-center">
        <div class="absolute inset-0 opacity-30">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                {{ $t['welcome'] }} в <span class="text-primary">FoodReciper</span>
            </h1>
            <p class="text-stone-300 text-lg mb-10">
                Откройте для себя тысячи уникальных рецептов от поваров со всего мира.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition shadow-xl shadow-emerald-900/20">
                    {{ $t['register'] }}
                </a>
            @endguest
        </div>
    </div>

    <div>
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-3xl font-bold text-dark">{{ $t['recipes'] }}</h2>
            <div class="text-stone-400 text-sm">{{ $recipes->count() }} позиций</div>
        </div>

        @if($recipes->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-stone-200">
                <p class="text-stone-400">Рецептов пока нет. Будьте первым!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recipes as $recipe)
                    <div class="group bg-white rounded-3xl shadow-soft border border-stone-100 overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-64 overflow-hidden relative">
                            <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute bottom-4 left-4 flex gap-2">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-dark shadow-sm">
                                    ⏳ {{ $recipe->cooking_time }} {{ $t['minutes'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-[10px] text-primary font-bold">
                                    {{ substr($recipe->user->username, 0, 1) }}
                                </div>
                                <a href="{{ route('profile.show', $recipe->user->username) }}" class="text-xs font-bold text-stone-400 hover:text-primary transition uppercase tracking-wider">
                                    {{ $recipe->user->username }}
                                </a>
                            </div>
                            
                            <h3 class="text-xl font-bold text-dark mb-2 line-clamp-1 group-hover:text-primary transition">
                                {{ $recipe->title }}
                            </h3>
                            
                            <p class="text-stone-500 text-sm line-clamp-2 mb-6 h-10">
                                {{ $recipe->description }}
                            </p>

                            <a href="{{ route('recipes.show', $recipe->id) }}" class="block text-center py-3 rounded-xl bg-stone-50 text-dark font-bold hover:bg-dark hover:text-white transition">
                                {{ $t['details'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection