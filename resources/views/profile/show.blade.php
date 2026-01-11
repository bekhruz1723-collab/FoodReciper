@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <div class="bg-white rounded-3xl shadow-soft p-8 mb-8 flex flex-col md:flex-row items-center md:items-start gap-8 border border-stone-100">
        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-stone-100 shadow-md flex-shrink-0">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-primary flex items-center justify-center text-4xl text-white font-bold">
                    {{ substr($user->username, 0, 1) }}
                </div>
            @endif
        </div>
        
        <div class="flex-grow text-center md:text-left">
            <h1 class="text-3xl font-bold text-dark">{{ $user->name }}</h1>
            <p class="text-stone-500 font-medium">@ {{ $user->username }}</p>
            
            @if($user->age)
                <span class="inline-block mt-2 px-3 py-1 bg-stone-100 rounded-full text-xs text-stone-600 font-bold">
                    {{ $user->age }} {{ $t['years_old'] }}
                </span>
            @endif

            <p class="mt-4 text-stone-600 max-w-xl">{{ $user->bio ?? $t['no_info'] }}</p>
        </div>

        @if(Auth::id() === $user->id)
            <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-stone-100 text-stone-700 font-bold rounded-xl hover:bg-stone-200 transition">
                ⚙ {{ $t['edit_profile'] }}
            </a>
        @endif
    </div>

    <h2 class="text-2xl font-bold mb-6 text-dark border-l-4 border-primary pl-4">
        {{ $t['recipes'] }} ({{ $recipes->count() }})
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe->id) }}" class="group bg-white rounded-2xl shadow-soft overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 border border-stone-100 flex flex-col h-full">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-3 right-3 bg-white/90 px-2 py-1 rounded-lg text-xs font-bold text-dark shadow-sm">
                        ⏳ {{ $recipe->cooking_time }} {{ $t['minutes'] }}
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-dark group-hover:text-primary transition mb-2">{{ $recipe->title }}</h3>
                    <p class="text-stone-500 text-sm line-clamp-2 mb-4 flex-grow">{{ $recipe->description }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection