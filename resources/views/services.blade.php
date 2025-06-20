@extends('layouts.app')
@section('title', 'Services')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center animate-fade-in-up">
    <h1 class="text-4xl font-bold mb-4 text-green-700">Our Services</h1>
    <ul class="text-lg text-gray-600 mb-8 max-w-xl mx-auto space-y-3">
        <li><i class="ph-book-open-bold text-blue-500 mr-2"></i>Online Book Borrowing</li>
        <li><i class="ph-users-bold text-purple-500 mr-2"></i>Community Reviews & Ratings</li>
        <li><i class="ph-device-mobile-bold text-green-500 mr-2"></i>Mobile Friendly Access</li>
        <li><i class="ph-shield-check-bold text-yellow-500 mr-2"></i>Secure & Private</li>
    </ul>
</div>
@endsection
