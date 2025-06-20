@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center animate-fade-in-up">
    <h1 class="text-4xl font-bold mb-4 text-pink-700">Contact Us</h1>
    <p class="text-lg text-gray-600 mb-4">Have questions or feedback? Reach out to us!</p>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-card p-8 max-w-md mx-auto">
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-2">
                <i class="ph-envelope-simple-bold text-blue-500"></i>
                <span class="text-gray-700 dark:text-gray-200">Email: <a href="mailto:info@librarydigital.com" class="text-blue-600 hover:underline">info@librarydigital.com</a></span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ph-phone-bold text-green-500"></i>
                <span class="text-gray-700 dark:text-gray-200">Phone: <a href="tel:+62123456789" class="text-blue-600 hover:underline">+62 123-456-789</a></span>
            </div>
        </div>
    </div>
</div>
@endsection
