@extends('layout')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6">
    
    <!-- Левая колонка (2/3 на десктопе, полная на мобиле) -->
    <div class="lg:col-span-2 w-full">
        <!-- Изображение рецепта и галерея -->
        <div class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm mb-4 sm:mb-5 md:mb-6">
            <!-- Главное фото -->
            <div class="w-full aspect-video bg-gradient-to-br from-stone-200 to-stone-300 overflow-hidden">
                <img src="@if(str_starts_with($recipe->image, 'http')){{ $recipe->image }}@else{{ asset('storage/' . $recipe->image) }}@endif" 
                     class="w-full h-full object-cover" 
                     alt="{{ $recipe->title }}">
            </div>
            
            <!-- Галерея дополнительных фото -->
            @if($recipe->gallery && count($recipe->gallery) > 0)
                <div class="p-3 sm:p-4 md:p-6 border-t border-gray-200">
                    <h4 class="text-xs sm:text-sm font-bold text-dark mb-3">Фото блюда</h4>

                    <!-- Thumbnails -->
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 sm:gap-3">
                        @foreach($recipe->gallery as $i => $photo)
                            @php
                                $photoUrl = str_starts_with($photo, 'http') ? $photo : asset('storage/' . $photo);
                            @endphp
                            <button type="button" data-index="{{ $i }}" class="gallery-thumb-btn relative aspect-square bg-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition cursor-pointer focus:outline-none">
                                <img src="{{ $photoUrl }}" alt="Фото блюда {{ $i + 1 }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>

                    <!-- Modal preview (hidden by default) -->
                    <div id="gallery-modal" class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-4">
                        <div class="relative max-w-[95%] max-h-[95%] w-full flex items-center justify-center">
                            <button id="gallery-close" class="absolute top-2 right-2 text-white bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full p-2 focus:outline-none">✕</button>

                            <button id="gallery-prev" aria-label="Previous" class="absolute left-2 sm:left-6 text-white bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full p-2 focus:outline-none">‹</button>

                            <img id="gallery-current" src="" alt="Просмотр фото" class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg shadow-lg" />

                            <button id="gallery-next" aria-label="Next" class="absolute right-2 sm:right-6 text-white bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full p-2 focus:outline-none">›</button>
                        </div>
                    </div>

                    <script>
                        (function(){
                            const images = [
                                @foreach($recipe->gallery as $photo)
                                    "@if(str_starts_with($photo, 'http')){{ $photo }}@else{{ asset('storage/' . $photo) }}@endif",
                                @endforeach
                            ];

                            const modal = document.getElementById('gallery-modal');
                            const imgEl = document.getElementById('gallery-current');
                            const btnPrev = document.getElementById('gallery-prev');
                            const btnNext = document.getElementById('gallery-next');
                            const btnClose = document.getElementById('gallery-close');
                            const thumbs = document.querySelectorAll('.gallery-thumb-btn');
                            let current = 0;

                            function open(index){
                                current = index;
                                imgEl.src = images[current];
                                modal.classList.remove('hidden');
                                document.body.classList.add('overflow-hidden');
                                // focus for keyboard events
                                btnClose.focus();
                            }

                            function close(){
                                modal.classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                                imgEl.src = '';
                            }

                            function prev(){
                                current = (current - 1 + images.length) % images.length;
                                imgEl.src = images[current];
                            }

                            function next(){
                                current = (current + 1) % images.length;
                                imgEl.src = images[current];
                            }

                            thumbs.forEach(btn => {
                                btn.addEventListener('click', (e) => {
                                    const idx = parseInt(btn.dataset.index, 10);
                                    open(idx);
                                });
                            });

                            btnPrev.addEventListener('click', (e) => { e.stopPropagation(); prev(); });
                            btnNext.addEventListener('click', (e) => { e.stopPropagation(); next(); });
                            btnClose.addEventListener('click', (e) => { e.stopPropagation(); close(); });

                            // Close when clicking outside image area
                            modal.addEventListener('click', (e) => {
                                if(e.target === modal){ close(); }
                            });

                            // Keyboard navigation
                            document.addEventListener('keydown', (e) => {
                                if(modal.classList.contains('hidden')) return;
                                if(e.key === 'ArrowLeft') { prev(); }
                                else if(e.key === 'ArrowRight') { next(); }
                                else if(e.key === 'Escape') { close(); }
                            });
                        })();
                    </script>
                </div>
            @endif
            
            <!-- Информация о рецепте -->
            <div class="p-3 sm:p-4 md:p-6">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-dark mb-2 sm:mb-3">{{ $recipe->title }}</h1>
                <p class="text-xs sm:text-sm md:text-base text-stone-600 mb-3 sm:mb-4 md:mb-5 line-clamp-3">{{ $recipe->description }}</p>
                
                @if($recipe->steps && count($recipe->steps) > 0)
                    <h3 class="text-sm sm:text-base md:text-lg font-bold text-dark mb-3 sm:mb-4">🧑‍🍳 {{ $t['how_to_cook'] ?? 'Как готовить:' }}</h3>
                    <div class="space-y-2 sm:space-y-3">
                        @foreach($recipe->steps as $index => $step)
                            <div class="flex gap-2 sm:gap-3 p-2.5 sm:p-3 bg-secondary rounded-lg hover:bg-orange-50 transition">
                                <div class="flex-shrink-0 w-7 sm:w-8 h-7 sm:h-8 bg-primary text-white rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed pt-0.5">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h3 class="text-sm sm:text-base md:text-lg font-bold text-dark mb-2 sm:mb-3">🧑‍🍳 {{ $t['how_to_cook'] ?? 'Как готовить:' }}</h3>
                    <div class="text-xs sm:text-sm text-stone-700 leading-relaxed whitespace-pre-line overflow-hidden max-h-48 sm:max-h-64 md:max-h-none">
                        {{ $recipe->instructions }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Отзывы -->
        <div class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm">
            <div class="p-3 sm:p-4 md:p-6">
                <h3 class="text-base sm:text-lg md:text-2xl font-bold mb-4 sm:mb-5 md:mb-6">{{ $t['reviews'] ?? 'Отзывы' }} ({{ $recipe->reviews->count() }})</h3>
                
                @auth
                    <!-- Форма добавления отзыва -->
                    <form action="{{ route('reviews.store', $recipe) }}" method="POST" enctype="multipart/form-data" class="mb-5 sm:mb-6 md:mb-8 bg-secondary p-3 sm:p-4 rounded-lg sm:rounded-2xl" id="reviewForm">
                        @csrf
                        
                        <!-- Выбор оценки -->
                        <div class="mb-3 sm:mb-4">
                            <label class="block font-bold mb-2 text-xs sm:text-sm md:text-base">{{ $t['rate_dish'] ?? 'Оцените блюдо:' }}</label>
                            <div class="flex gap-1 items-center mb-2">
                                <div id="star-rating" class="flex gap-0.5 sm:gap-1 md:gap-2 items-center">
                                    <button type="button" class="star-btn text-lg sm:text-xl md:text-3xl transition-all flex-shrink-0" data-rating="1">⭐</button>
                                    <button type="button" class="star-btn text-lg sm:text-xl md:text-3xl transition-all flex-shrink-0" data-rating="2">⭐</button>
                                    <button type="button" class="star-btn text-lg sm:text-xl md:text-3xl transition-all flex-shrink-0" data-rating="3">⭐</button>
                                    <button type="button" class="star-btn text-lg sm:text-xl md:text-3xl transition-all flex-shrink-0" data-rating="4">⭐</button>
                                    <button type="button" class="star-btn text-lg sm:text-xl md:text-3xl transition-all flex-shrink-0" data-rating="5">⭐</button>
                                </div>
                            </div>
                            <div id="rating-error" class="text-red-500 text-xs sm:text-sm font-bold" style="display: none;">{{ $t['specify_rating'] ?? 'Укажите оценку!' }}</div>
                            <input type="hidden" name="rating" id="rating-input" value="">
                        </div>

                        <!-- Текст комментария -->
                        <div class="mb-3">
                            <textarea name="comment" 
                                      class="w-full p-2 sm:p-3 rounded-lg border border-stone-200 text-xs sm:text-sm resize-none" 
                                      rows="3"
                                      placeholder="{{ $t['comment_optional'] ?? 'Комментарий... (опционально)' }}"></textarea>
                        </div>

                        <!-- Загрузка фото -->
                        <div class="mb-3 sm:mb-4">
                            <label class="block font-bold mb-2 text-xs sm:text-sm">{{ $t['photo_optional'] ?? 'Фото (опционально):' }}</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs p-2 rounded-lg border border-stone-200">
                            <p class="text-xs text-stone-500 mt-1">{{ $t['max_size'] ?? 'Макс 2МБ' }}: JPEG, PNG, JPG, GIF</p>
                        </div>

                        <!-- Кнопка отправки -->
                        <button type="submit" class="w-full bg-primary text-white px-3 py-2 rounded-lg sm:rounded-xl hover:bg-orange-600 transition-colors text-xs sm:text-sm md:text-base font-bold">
                            {{ $t['submit'] ?? 'Отправить' }}
                        </button>
                    </form>

                    <style>
                        .star-btn {
                            background: none;
                            border: none;
                            cursor: pointer;
                            filter: grayscale(100%);
                            opacity: 0.5;
                            padding: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            line-height: 1;
                        }
                        
                        .star-btn.active {
                            filter: grayscale(0%);
                            opacity: 1;
                        }
                        
                        .star-btn:active {
                            transform: scale(1.1);
                        }
                    </style>

                    <script>
                        const ratingInput = document.getElementById('rating-input');
                        const starButtons = document.querySelectorAll('.star-btn');
                        const ratingError = document.getElementById('rating-error');
                        const reviewForm = document.getElementById('reviewForm');
                        
                        starButtons.forEach(btn => {
                            btn.addEventListener('click', (e) => {
                                e.preventDefault();
                                const rating = btn.dataset.rating;
                                ratingInput.value = rating;
                                ratingError.style.display = 'none';
                                
                                starButtons.forEach(star => {
                                    if (star.dataset.rating <= rating) {
                                        star.classList.add('active');
                                    } else {
                                        star.classList.remove('active');
                                    }
                                });
                            });
                        });
                        
                        reviewForm.addEventListener('submit', (e) => {
                            if (!ratingInput.value) {
                                e.preventDefault();
                                ratingError.style.display = 'block';
                                ratingError.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                        });
                    </script>
                @else
                    <div class="bg-gray-100 p-3 sm:p-4 rounded-lg text-center mb-5 sm:mb-6">
                        <a href="{{ route('login') }}" class="text-primary font-bold underline text-xs sm:text-sm">{{ $t['login'] ?? 'Войдите' }}</a>, {{ $t['to_leave_review'] ?? 'чтобы оставить отзыв.' }}
                    </div>
                @endauth

                <!-- Список отзывов -->
                <div class="space-y-3 sm:space-y-4">
                    @forelse($recipe->reviews as $review)
                        <div class="border-b border-gray-200 pb-3 sm:pb-4 last:border-b-0">
                            <div class="flex gap-2 sm:gap-3 mb-2">
                                <div class="w-8 sm:w-9 h-8 sm:h-9 rounded-full overflow-hidden flex-shrink-0 bg-gray-300">
                                    <img src="@if($review->user->avatar && str_starts_with($review->user->avatar, 'http')){{ $review->user->avatar }}@elseif($review->user->avatar){{ asset('storage/' . $review->user->avatar) }}@else{{ 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}@endif" 
                                         alt="{{ $review->user->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <span class="font-bold text-dark text-xs sm:text-sm truncate">{{ $review->user->name }}</span>
                                        <span class="text-primary text-xs sm:text-sm font-semibold flex-shrink-0">★ {{ $review->rating }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($review->comment)
                                <p class="text-stone-600 text-xs sm:text-sm mb-2 ml-10 sm:ml-12">{{ $review->comment }}</p>
                            @endif
                            
                            @if($review->image)
                                <div class="mt-2 ml-10 sm:ml-12">
                                    <img src="{{ asset('storage/' . $review->image) }}" 
                                         alt="Фото отзыва" 
                                         class="rounded-lg w-full sm:max-w-xs h-28 sm:h-40 object-cover">
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-stone-500 text-xs sm:text-sm py-4">{{ $t['no_reviews'] ?? 'Отзывов пока нет' }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Правая колонка (1/3 на десктопе, полная на мобиле) -->
    <div class="lg:col-span-1 w-full">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 shadow-sm sticky top-14 sm:top-16 md:top-20 z-20">
            <!-- Информация об авторе -->
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 mb-4 sm:mb-5 md:mb-6 pb-3 sm:pb-4 border-b border-gray-200">
                <div class="w-9 sm:w-10 md:w-12 h-9 sm:h-10 md:h-12 rounded-full overflow-hidden flex-shrink-0 bg-gray-300">
                    <img src="@if($recipe->user->avatar && str_starts_with($recipe->user->avatar, 'http')){{ $recipe->user->avatar }}@elseif($recipe->user->avatar){{ asset('storage/' . $recipe->user->avatar) }}@else{{ 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) }}@endif" 
                         alt="{{ $recipe->user->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-stone-400">{{ $t['author'] ?? 'Автор' }}</p>
                    <p class="font-bold text-dark text-xs sm:text-sm truncate">{{ $recipe->user->name }}</p>
                </div>
            </div>

            <!-- Ингредиенты -->
            <h3 class="text-sm sm:text-base md:text-lg font-bold mb-2.5 sm:mb-3">🥕 {{ $t['ingredients'] ?? 'Ингредиенты' }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm md:text-base border-collapse">
                    <thead>
                        <tr class="text-left text-stone-500 text-xs sm:text-sm">
                            <th class="py-2 px-2">{{ $t['product'] ?? 'Продукт' }}</th>
                            <th class="py-2 px-2 text-right">{{ $t['amount'] ?? 'Кол-во' }}</th>
                            <th class="py-2 px-2 text-right">{{ $t['weight'] ?? 'Вес' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipe->ingredients as $ing)
                            <tr class="border-t border-gray-100 hover:bg-orange-50 transition">
                                <td class="py-2 px-2">
                                    <div class="truncate">{{ $ing->name }}</div>
                                </td>
                                <td class="py-2 px-2 text-right font-bold text-stone-600">{{ $ing->pivot->amount }}</td>
                                <td class="py-2 px-2 text-right text-stone-500">@if($ing->pivot->weight){{ $ing->pivot->weight }}г@else-@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection