<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodReciper</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        primaryHover: '#047857',
                        dark: '#1c1917',
                        surface: '#ffffff',
                        background: '#fafaf9',
                    },
                    boxShadow: { 'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)' }
                }
            }
        }
    </script>
    <style>
        body { background-color: #fafaf9; font-family: 'Inter', system-ui, sans-serif; color: #1c1917; }
        /* Делаем инпуты явно белыми и очерченными */
        input, textarea, select { 
            background-color: #ffffff !important; 
            border: 1px solid #e7e5e4 !important; 
        }
        input:focus, textarea:focus {
            border-color: #059669 !important;
            ring: 2px solid #059669;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <nav class="bg-white border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 flex justify-between items-center gap-2 sm:gap-3 md:gap-4">
            <a href="{{ route('home') }}" class="text-base sm:text-lg md:text-2xl font-bold tracking-tight text-dark flex items-center gap-1 sm:gap-2 flex-shrink-0 min-w-0">
                <span class="text-lg sm:text-xl md:text-3xl flex-shrink-0">🌿</span>
                <span class="inline truncate">FoodReciper</span>
            </a>

            @auth
                <a href="{{ route('recipes.create') }}" class="hidden sm:flex items-center text-xs sm:text-sm text-stone-600 hover:text-primary transition whitespace-nowrap flex-shrink-0">
                    ➕ {{ $t['add_recipe'] ?? 'Добавить' }}
                </a>
            @endauth
            
            <div class="flex gap-1.5 sm:gap-2 md:gap-4 items-center text-xs sm:text-sm font-medium">
                <div class="flex border rounded-lg overflow-hidden flex-shrink-0">
                    <a href="{{ route('locale', 'ru') }}" class="px-2 sm:px-3 py-1 text-xs {{ $current_locale == 'ru' ? 'bg-primary text-white' : 'bg-white hover:bg-stone-100' }}">RU</a>
                    <a href="{{ route('locale', 'en') }}" class="px-2 sm:px-3 py-1 text-xs {{ $current_locale == 'en' ? 'bg-primary text-white' : 'bg-white hover:bg-stone-100' }}">EN</a>
                    <a href="{{ route('locale', 'uz') }}" class="px-2 sm:px-3 py-1 text-xs {{ $current_locale == 'uz' ? 'bg-primary text-white' : 'bg-white hover:bg-stone-100' }}">UZ</a>
                </div>

                @auth
                    <style>
                        .profile-dropdown {
                            position: relative;
                        }
                        
                        .profile-menu {
                            position: absolute;
                            top: 100%;
                            right: 0;
                            margin-top: 0.5rem;
                            opacity: 0;
                            visibility: hidden;
                            transition: opacity 0.2s, visibility 0.2s;
                            pointer-events: none;
                        }
                        
                        .profile-dropdown:hover .profile-menu,
                        .profile-dropdown:focus-within .profile-menu {
                            opacity: 1;
                            visibility: visible;
                            pointer-events: auto;
                        }
                    </style>

                    <div class="relative flex-shrink-0 profile-dropdown">
                        <button class="flex items-center gap-1 sm:gap-2 font-bold text-dark text-xs sm:text-sm px-2 sm:px-3 py-1.5 rounded-lg hover:bg-stone-50 truncate profile-btn focus:outline-none focus:ring-2 focus:ring-primary">
                            {{ substr(Auth::user()->username, 0, 8) }}
                        </button>
                        <div class="profile-menu w-44 sm:w-48 bg-white rounded-xl shadow-xl border border-stone-100 p-1.5 sm:p-2 text-xs sm:text-sm z-50">
                            <a href="{{ route('profile.show', Auth::user()->username) }}" class="block px-3 sm:px-4 py-1.5 sm:py-2 hover:bg-stone-50 rounded-lg cursor-pointer transition">{{ $t['my_profile'] }}</a>
                            <a href="{{ route('profile.edit') }}" class="block px-3 sm:px-4 py-1.5 sm:py-2 hover:bg-stone-50 rounded-lg cursor-pointer transition">{{ $t['settings'] }}</a>
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-stone-100 mt-1 pt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 sm:px-4 py-1.5 sm:py-2 text-red-500 hover:bg-red-50 rounded-lg cursor-pointer font-normal transition">{{ $t['logout'] }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline text-stone-600 text-xs sm:text-sm hover:text-primary">{{ $t['login'] }}</a>
                    <a href="{{ route('register') }}" class="bg-dark text-white px-2.5 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm hover:bg-stone-800 transition shadow-lg flex-shrink-0 font-bold">{{ $t['register'] ?? 'Вход' }}</a>
                @endauth
            </div>
        </div>

        @auth
            <div class="sm:hidden border-t border-stone-200 bg-stone-50 px-3 py-2 flex gap-2">
                <a href="{{ route('recipes.create') }}" class="flex-1 bg-primary text-white text-xs py-2 rounded-lg text-center hover:bg-orange-600 transition font-bold">
                    ➕ Рецепт
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 text-white text-xs py-2 rounded-lg hover:bg-red-600 transition font-bold">
                        Выход
                    </button>
                </form>
            </div>
        @else
            <div class="sm:hidden border-t border-stone-200 bg-stone-50 px-3 py-2 flex gap-2">
                <a href="{{ route('login') }}" class="flex-1 bg-dark text-white text-xs py-2 rounded-lg text-center hover:bg-stone-800 transition font-bold">
                    Вход
                </a>
                <a href="{{ route('register') }}" class="flex-1 bg-primary text-white text-xs py-2 rounded-lg text-center hover:bg-orange-600 transition font-bold">
                    Регистрация
                </a>
            </div>
        @endauth
    </nav>

    <main class="flex-grow w-full max-w-7xl mx-auto px-3 sm:px-4 md:px-6 py-4 sm:py-6 md:py-10">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-stone-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center text-stone-400 text-sm">
            <p>&copy; 2026 {{ $t['footer'] }}</p>
        </div>
    </footer>

</body>
</html>