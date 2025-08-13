@extends('layouts.app')
@section('title', 'Daftar Kost Tersedia')
@section('content')
    <div class="max-w-7xl mx-auto py-4">
        <ul class="flex flex-wrap gap-4 justify-center py-6">
            @foreach ($categories as $index => $category)
                @php
                    $isActive = $selectedCategory === $category->id;
                @endphp
                <li>
                    <a href="{{ route('showCategories', Crypt::encrypt($category->id)) }}"
                        class="hover:bg-primary hover:text-white border border-primary  outline-primary px-6 py-2 rounded-lg font-medium text-sm transition duration-300
                        {{ $isActive ? 'bg-blue-600 text-white' : 'bg-transparent text-blue-600' }}">
                        {{ $category->category_name }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('list-kost') }}"
                    class=" hover:bg-blue-600 hover:text-white border border-blue-500  outline-blue-500 px-6 py-2 rounded-lg font-medium text-sm transition duration-300
                    {{ $selectedCategory === null ? 'bg-blue-600 text-white' : 'bg-transparent text-blue-600' }}">Lihat
                    Semua
                </a>
            </li>
        </ul>
    </div>
    <div class="grid grid-cols-2 gap-6 mb-4">
        @foreach ($boardingHouses as $index => $boardingHouse)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover grid grid-cols-2 gap-6">
                <div class="relative h-74 overflow-hidden">
                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" alt="{{ $boardingHouse->name }}"
                            class="w-full h-full object-fit-cover" />
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-accent text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $boardingHouse->categories->category_name }}
                        </span>
                    </div>
                </div>


                <div class="p-6">
                    {{-- Jumlah Tipe Kamar --}}
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-800 flex-1 mr-2">{{ $boardingHouse->name }}</h3>
                        <div class="flex items-center text-white flex-shrink-0 bg-blue-800 px-2 py-1 rounded-full text-xs">
                            <span class="ml-1 text-sm font-semibold">{{ $boardingHouse->rooms->count() }} Tipe
                                Kamar</span>
                        </div>
                    </div>

                    {{-- Alamat Kos --}}
                    <p class="text-gray-600 mb-4 flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm leading-5">{{ $boardingHouse->address }}</span>
                    </p>

                    {{-- Range Harga Perbulan --}}
                    <div class="mb-4">
                        @php
                            $minPrice = $boardingHouse->rooms->min('price_per_month');
                            $maxPrice = $boardingHouse->rooms->max('price_per_month');
                        @endphp

                        @if ($minPrice === $maxPrice)
                            <div class="text-lg font-bold text-primary">
                                Rp {{ number_format($minPrice, 0, ',', '.') }}
                                <span class="text-sm font-normal text-gray-500">/bulan</span>
                            </div>
                        @else
                            <div class="text-lg font-bold text-primary">
                                Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp
                                {{ number_format($maxPrice, 0, ',', '.') }}
                                <span class="text-sm font-normal text-gray-500">/bulan</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex">
                        <div class="flex mb-4">
                            <a href="{{ route('details', Crypt::encrypt($boardingHouse->id)) }}"
                                class=" text-blue-500 border border-blue-500  px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300 text-xs font-semibold whitespace-nowrap">
                                Click For More Information
                            </a>
                        </div>
                    </div>


                    <!-- Features and Action Button -->
                    <div class="flex items-center justify-between">
                        @php
                            $facilites = $boardingHouse->rooms
                                ->flatmap(fn($room) => $room->facilities)
                                ->unique('facilities_name');
                        @endphp
                        <div class="flex flex-wrap gap-1 ">
                            @if ($facilites->count())
                                @foreach ($facilites as $facility)
                                    <span
                                        class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">{{ $facility->facilities_name }}</span>
                                @endforeach
                            @else
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Tidak ada
                                    fasilitas</span>
                            @endif
                            {{-- @foreach ($boardingHouse->rooms as $room)
                                    @if ($room->facilities && $room->facilities->count())
                                        @foreach ($room->facilities as $facility)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                                                {{ $facility->facilities_name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Tidak ada
                                            fasilitas</span>
                                    @endif
                                @endforeach --}}
                        </div>
                        {{-- <a href="{{ route('details', Crypt::encrypt($boardingHouse->id)) }}"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 text-sm font-semibold whitespace-nowrap ml-2">
                                More Information
                            </a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (empty($boardingHouses) || count($boardingHouses) == 0)
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Kos Tersedia</h3>
            <p class="text-gray-500">Silakan coba lagi nanti atau hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    @endif
@endsection
