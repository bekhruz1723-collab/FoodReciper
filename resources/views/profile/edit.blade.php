@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-10 rounded-3xl shadow-soft border border-stone-100">
        <h1 class="text-3xl font-bold text-dark mb-8">{{ $t['edit_profile'] }}</h1>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">{{ $t['avatar_label'] }}</label>
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-stone-100 border border-stone-200">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" id="avatarPreview" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-stone-400">?</div>
                        @endif
                    </div>
                    <input type="file" name="avatar" class="text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-stone-100 file:text-stone-700 hover:file:bg-stone-200" onchange="previewAvatar(this)">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['name_label'] }}</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['age'] }}</label>
                    <input type="number" name="age" value="{{ $user->age }}" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['bio_label'] }}</label>
                <textarea name="bio" rows="3" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary">{{ $user->bio }}</textarea>
            </div>

            <hr class="border-stone-200 my-6">

            <h3 class="text-lg font-bold text-dark">{{ $t['password_change'] }}</h3>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['old_password'] }}</label>
                <input type="password" name="old_password" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['new_password'] }}</label>
                    <input type="password" name="new_password" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">{{ $t['new_password_repeat'] }}</label>
                    <input type="password" name="new_password_confirmation" class="w-full p-3 rounded-xl bg-white border border-stone-300 shadow-sm focus:ring-primary">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-4">
                <a href="{{ route('profile.show', $user->username) }}" class="px-6 py-3 text-stone-500 font-bold hover:bg-stone-100 rounded-xl transition">{{ $t['cancel'] }}</a>
                <button class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primaryHover transition">
                    {{ $t['save'] }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection