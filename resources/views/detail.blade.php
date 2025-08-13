@extends('layouts.app')
@section('title', 'Detail Kost ' . $boardingHouse->name)
@section('content')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-6 text-white">
                    <h1 class="text-3xl font-bold mb-2">{{ $boardingHouse->name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="bg-yellow-400 text-yellow-900 px-4 py-2 text-sm font-semibold rounded-full shadow">
                            {{ $boardingHouse->categories->category_name }}
                        </span>
                        <span class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 text-sm font-semibold rounded-full">
                            {{ $boardingHouse->rooms->count() }} Tipe Kamar
                        </span>
                    </div>
                    <!-- Price Display -->
                    @php
                        $minPrice = $boardingHouse->rooms->min('price_per_month');
                        $maxPrice = $boardingHouse->rooms->max('price_per_month');
                    @endphp
                    <div class="text-2xl font-bold mb-4">
                        @if ($minPrice === $maxPrice)
                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}
                        @endif
                        <span class="text-lg font-normal opacity-90">/bulan</span>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start text-white text-opacity-90">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        <span class="leading-6">{{ $boardingHouse->address }}</span>
                    </div>
                </div>
            </div>

            <!-- Rooms Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Kamar & Fasilitas
                    </h2>
                    <span class="text-sm text-gray-500">{{ $boardingHouse->rooms->count() }} Tipe kamar tersedia</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($boardingHouse->rooms as $index => $room)
                        <div
                            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                            <!-- Room Header -->
                            <div class="bg-gradient-to-r from-gray-800 to-gray-700 px-6 py-4 text-white">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold">{{ $room->room_name }}</h3>
                                    <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">
                                        #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Room Images -->
                            <div class="relative">
                                @if ($room->roomImage && count($room->roomImage))
                                    <div class="relative h-48 overflow-hidden">
                                        @if (count($room->roomImage) > 1)
                                            <!-- Image Carousel for multiple images -->
                                            <div class="relative h-full">
                                                @foreach ($room->roomImage as $imageIndex => $image)
                                                    <img src="{{ asset('storage/' . $image->image) }}"
                                                        alt="Room Image {{ $imageIndex + 1 }}"
                                                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $imageIndex === 0 ? 'opacity-100' : 'opacity-0' }}"
                                                        data-image-index="{{ $imageIndex }}" />
                                                @endforeach

                                                <!-- Image Counter -->
                                                <div
                                                    class="absolute top-3 right-3 bg-black bg-opacity-70 text-white px-2 py-1 rounded-full text-xs">
                                                    <span class="current-image">1</span>/{{ count($room->roomImage) }}
                                                </div>

                                                <!-- Navigation Dots -->
                                                @if (count($room->roomImage) > 1)
                                                    <div
                                                        class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                                        @foreach ($room->roomImage as $imageIndex => $image)
                                                            <button
                                                                class="w-2 h-2 rounded-full transition-all {{ $imageIndex === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }}"
                                                                onclick="showImage({{ $index }}, {{ $imageIndex }})"></button>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Single image -->
                                            <img src="{{ asset('storage/' . $room->roomImage[0]->image) }}"
                                                alt="Room Image" class="w-full h-full object-cover" />
                                        @endif
                                    </div>
                                @else
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        <div class="text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="text-sm">Tidak ada gambar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Room Details -->
                            <div class="p-6">
                                <!-- Price -->
                                <div class="mb-4 text-center">
                                    <span class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($room->price_per_month, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">/bulan</span>
                                </div>

                                <!-- Room Info -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-sm text-gray-600 mb-1">Tipe</div>
                                        <div class="font-semibold text-gray-800">{{ $room->room_type }}</div>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-sm text-gray-600 mb-1">Ukuran</div>
                                        <div class="font-semibold text-gray-800">{{ $room->square_feet }} sqft</div>
                                    </div>
                                </div>

                                <!-- Availability Status -->
                                <div class="mb-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $room->is_available
                                        ? 'bg-green-100 text-green-800 border border-green-200'
                                        : 'bg-red-100 text-red-800 border border-red-200' }}">
                                        <div
                                            class="w-2 h-2 rounded-full mr-2
                                        {{ $room->is_available ? 'bg-green-500' : 'bg-red-500' }}">
                                        </div>
                                        {{ $room->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </div>

                                <!-- Facilities -->
                                <div class="border-t pt-4">
                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                            </path>
                                        </svg>
                                        Fasilitas
                                    </h4>

                                    @if ($room->facilities && $room->facilities->count())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($room->facilities as $facility)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md border border-blue-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ $facility->facilities_name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 text-sm italic flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Tidak ada fasilitas tersedia
                                        </p>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="mt-6">
                                    @if ($room->is_available)
                                        @if (Auth::check() == false)
                                            <button onclick="login()"
                                                class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg font-semibold cursor-not-allowed">
                                                Silakan login untuk menyewa
                                            </button>
                                        @else
                                            <button onclick="openModal({{ $room->id }},{{ $room->price_per_month }})"
                                                type="button"
                                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                                Sewa Sekarang
                                            </button>
                                        @endif
                                    @else
                                        <button
                                            class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg font-semibold cursor-not-allowed"
                                            disabled>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @include('partials.modalsewa')
    </div>

    <script>
        function login() {
            window.location.href = "/login";
        }
    </script>

    <!-- JavaScript for Image Carousel -->
    <script>
        function showImage(roomIndex, imageIndex) {
            const roomCard = document.querySelectorAll('.grid > div')[roomIndex];
            const images = roomCard.querySelectorAll('img[data-image-index]');
            const dots = roomCard.querySelectorAll('button');
            const counter = roomCard.querySelector('.current-image');

            // Hide all images
            images.forEach(img => img.classList.remove('opacity-100'));
            images.forEach(img => img.classList.add('opacity-0'));

            // Show selected image
            images[imageIndex].classList.remove('opacity-0');
            images[imageIndex].classList.add('opacity-100');

            // Update dots
            dots.forEach(dot => dot.classList.remove('bg-white'));
            dots.forEach(dot => dot.classList.add('bg-white', 'bg-opacity-50'));
            dots[imageIndex].classList.remove('bg-opacity-50');
            dots[imageIndex].classList.add('bg-white');

            // Update counter
            if (counter) {
                counter.textContent = imageIndex + 1;
            }
        }

        // Auto-rotate images every 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const roomCards = document.querySelectorAll('.grid > div');

            roomCards.forEach((card, roomIndex) => {
                const images = card.querySelectorAll('img[data-image-index]');
                if (images.length > 1) {
                    let currentIndex = 0;
                    setInterval(() => {
                        currentIndex = (currentIndex + 1) % images.length;
                        showImage(roomIndex, currentIndex);
                    }, 5000);
                }
            });
        });
    </script>

    <script>
        function openModal(roomId, pricePerMonth) {
            document.getElementById('modalSewa').classList.remove('hidden');
            document.getElementById('room_id').value = roomId;
            document.getElementById('price_per_month').value = pricePerMonth;
        }

        function closeModal() {
            document.getElementById('modalSewa').classList.add('hidden');
        }
    </script>



@endsection
