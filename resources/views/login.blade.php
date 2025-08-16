@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-xl min-h-screen flex items-center justify-center">
    <div class="bg-white w-full max-w-xl rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
        <p class="text-center text-gray-400 mb-10">Enter your credentials to access your account</p>
        <form method="POST" action="{{ route('auth') }}" class="max-w-md mx-auto">
            @csrf
            <div class="mb-6">
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your password" required>
            </div>
            <div class="mb-11">
                <input type="checkbox" id="showPassword" class="mr-2">
                <label for="showPassword">Show Password</label>
            </div>
            <button type="submit"
                class="w-full bg-black text-white py-2 px-4 rounded-md  transition-colors duration-300 hover:bg-gray-900">Login</button>
        </form>
        <p class="text-center mt-3 text-gray-500">Don't have an account ? <a href="{{ route('register') }}" class="text-black hover:underline">Register</a></p>
    </div>
</div>
<script>
    document.getElementById('showPassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        passwordInput.type = this.checked ? 'text' : 'password';
    });
</script>
@endsection