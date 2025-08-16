{{-- filepath: c:\laragon\www\persewaan-kos\resources\views\register.blade.php --}}
@extends('layouts.app')
@section('title', 'Registrasi')
@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6" x-data="{ tab: 'login' }">
        <!-- Tabs -->
        <div class="flex justify-center mb-6">
            <button 
                class="w-1/2 py-2 font-medium border-b-2"
                :class="tab === 'login' ? 'border-black text-black' : 'border-transparent text-gray-400'"
                @click="tab = 'login'">
                Login
            </button>
            <button 
                class="w-1/2 py-2 font-medium border-b-2"
                :class="tab === 'register' ? 'border-black text-black' : 'border-transparent text-gray-400'"
                @click="tab = 'register'">
                Register
            </button>
        </div>

        <!-- Login Form -->
        <div x-show="tab === 'login'">
            <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
            <form method="POST" action="{{ route('auth') }}" class="max-w-md mx-auto">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your email" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your password" required>
                </div>
                <button type="submit"
                    class="w-full bg-black text-white py-2 px-4 rounded-md transition-colors duration-300">
                    Login
                </button>
            </form>
        </div>

        <!-- Register Form -->
        <div x-show="tab === 'register'" x-cloak>
            <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>
            <form method="POST" action="{{ route('register') }}" class="max-w-md mx-auto">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your name" required>
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block font-medium text-gray-700">No Telp</label>
                    <input type="number" id="phone_number" name="phone_number" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your name" required>
                </div>
                <div class="mb-4">
                    <label for="email_reg" class="block font-medium text-gray-700">Email</label>
                    <input type="email" id="email_reg" name="email" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label for="password_reg" class="block font-medium text-gray-700">Password</label>
                    <input type="password" id="password_reg" name="password" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Enter your password" required>
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full p-2 border border-gray-300 rounded-md" 
                           placeholder="Confirm your password" required>
                </div>
                <button type="submit"
                    class="w-full bg-black text-white py-2 px-4 rounded-md transition-colors duration-300">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const showPwCheckbox = document.getElementById('show_pw');
    const pwError = document.getElementById('pw-error');

    // Tampilkan/Sembunyikan Password
    showPwCheckbox.addEventListener('change', function() {
        const type = this.checked ? 'text' : 'password';
        passwordInput.type = type;
        confirmPasswordInput.type = type;
    });

    // Validasi Password Tidak Cocok
    function validatePassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            pwError.classList.remove('hidden');
            confirmPasswordInput.setCustomValidity('Password tidak cocok');
        } else {
            pwError.classList.add('hidden');
            confirmPasswordInput.setCustomValidity('');
        }
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
});
</script> --}}