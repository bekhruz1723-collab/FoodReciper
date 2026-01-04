@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-dark mb-8">{{ $t['create_title'] }}</h1>

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="bg-white p-8 rounded-3xl shadow-soft border border-stone-100 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['recipe_name'] }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Напр. Паста Карбонара" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['recipe_desc'] }}</label>
                    <textarea name="description" rows="3" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-2 focus:ring-primary transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['cooking_time'] }} ({{ $t['minutes'] }}) <span class="text-red-500">*</span></label>
                    <input type="number" name="cooking_time" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-2 focus:ring-primary transition" required>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['main_photo'] }} <span class="text-red-500">*</span></label>
                    <div class="relative w-full h-48 border-2 border-dashed border-stone-300 rounded-xl flex items-center justify-center bg-stone-50 hover:bg-stone-100 transition overflow-hidden">
                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="previewFile(this, 'mainPreview')">
                        <img id="mainPreview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <span class="text-stone-400">Нажмите для загрузки</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['gallery'] }}</label>
                    <input type="file" name="gallery[]" multiple accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primaryHover">
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-soft border border-stone-100">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">🍅 {{ $t['ingredients'] }}</h2>
            
            <div id="ingredients-list" class="space-y-3">
                <div class="grid grid-cols-12 gap-3 items-end">
                    <div class="col-span-6">
                        <label class="text-xs font-bold text-stone-500 ml-1 uppercase">{{ $t['ing_name'] }}</label>
                        <input type="text" name="ingredients[0][name]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm" required>
                    </div>
                    <div class="col-span-3">
                        <label class="text-xs font-bold text-stone-500 ml-1 uppercase">{{ $t['ing_amount'] }}</label>
                        <input type="text" name="ingredients[0][amount]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm" placeholder="2 шт">
                    </div>
                    <div class="col-span-3">
                        <label class="text-xs font-bold text-stone-500 ml-1 uppercase">{{ $t['ing_weight'] }}</label>
                        <input type="number" name="ingredients[0][weight]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm">
                    </div>
                </div>
            </div>

            <button type="button" onclick="addIngredient()" class="mt-4 text-primary font-bold hover:underline flex items-center gap-1">
                {{ $t['add_ingredient_btn'] }}
            </button>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-soft border border-stone-100">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">🍳 {{ $t['steps'] }}</h2>
            
            <div id="steps-list" class="space-y-4">
                <div class="flex gap-4">
                    <span class="font-bold text-3xl text-stone-200 mt-1">1</span>
                    <textarea name="steps[]" rows="2" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm focus:ring-2 focus:ring-primary" placeholder="{{ $t['step_placeholder'] }}"></textarea>
                </div>
            </div>

            <button type="button" onclick="addStep()" class="mt-4 text-primary font-bold hover:underline flex items-center gap-1">
                {{ $t['add_step_btn'] }}
            </button>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('home') }}" class="px-8 py-4 rounded-xl font-bold text-stone-500 hover:bg-stone-100 transition">{{ $t['cancel'] }}</a>
            <button type="submit" class="px-10 py-4 rounded-xl font-bold bg-primary text-white shadow-lg shadow-emerald-200 hover:bg-primaryHover hover:shadow-xl transition transform hover:-translate-y-1">
                {{ $t['save'] }}
            </button>
        </div>
    </form>
</div>

<script>
    let ingIndex = 1;
    function addIngredient() {
        const div = document.createElement('div');
        div.className = 'grid grid-cols-12 gap-3 items-end pt-2 border-t border-stone-100';
        div.innerHTML = `
            <div class="col-span-6">
                <input type="text" name="ingredients[${ingIndex}][name]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm" required placeholder="{{ $t['ing_name'] }}">
            </div>
            <div class="col-span-3">
                <input type="text" name="ingredients[${ingIndex}][amount]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm" placeholder="{{ $t['ing_amount'] }}">
            </div>
            <div class="col-span-3">
                <input type="number" name="ingredients[${ingIndex}][weight]" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm" placeholder="{{ $t['ing_weight'] }}">
            </div>
        `;
        document.getElementById('ingredients-list').appendChild(div);
        ingIndex++;
    }

    let stepIndex = 2;
    function addStep() {
        const div = document.createElement('div');
        div.className = 'flex gap-4 pt-4 border-t border-stone-100';
        div.innerHTML = `
            <span class="font-bold text-3xl text-stone-200 mt-1">${stepIndex}</span>
            <textarea name="steps[]" rows="2" class="w-full p-3 rounded-lg bg-white border border-stone-300 shadow-sm focus:ring-2 focus:ring-primary" placeholder="{{ $t['step_placeholder'] }}"></textarea>
        `;
        document.getElementById('steps-list').appendChild(div);
        stepIndex++;
    }

    function previewFile(input, imgId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                img.src = e.target.result;
                img.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection