@extends('layouts.app')

@section('title', 'Lupa Password - Library Digital')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center mb-6">Lupa Password</h2>
    @if (session('status'))
        <div class="mb-4 font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                required autofocus>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Kirim Link Reset Password
        </button>
    </form>
    <p class="mt-4 text-center text-gray-600">
        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600">Kembali ke Login</a>
    </p>
</div>
@endsection
