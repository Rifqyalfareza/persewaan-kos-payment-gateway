{{-- filepath: c:\laragon\www\persewaan-kos\resources\views\register.blade.php --}}
@extends('layouts.app')
@section('title', 'Registrasi')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Registrasi</h1>
    <form method="POST" action="{{ route('register.store') }}" class="max-w-md mx-auto">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="phone_number" class="block font-medium text-gray-700">Nomor Telepon</label>
            <input type="number" id="phone_number" name="phone_number" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded-md" required>
            <span id="pw-error" class="text-red-500 text-sm mt-1 hidden">Password tidak cocok</span>
        </div>
        <div class="mb-4">
            <input type="checkbox" id="show_pw" class="mr-2">
            <label for="show_pw" class="text-gray-700">Tampilkan Password</label>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300">Daftar</button>
    </form>
</div>
@endsection

<script>
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
</script>