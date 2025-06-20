@extends('layouts.app')

@section('title', 'Login - Library Digital')


@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required>
                <i class="fas fa-eye absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer hover:text-gray-700"
                    onclick="togglePassword('password', this)"></i>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Login
        </button>
    </form>

    <p class="mt-4 text-center text-gray-600">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600">Register here</a>
    </p>
    <p class="mt-2 text-center">
        <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-600 text-sm">Lupa Password?</a>
    </p>
</div>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
