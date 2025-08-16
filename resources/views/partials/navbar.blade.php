<nav class="bg-white shadow-md top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-primary">
                    <span class="text-secondary">Kos</span>Ku
                </h1>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-700 hover:text-blue-500 font-medium">Home</a>
                <a href="{{ route('list-kost') }}" class="text-gray-700 hover:text-blue-500 font-medium">Daftar Kos</a>
                <a href="#" class="text-gray-700 hover:text-blue-500 font-medium">About Us</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-4">
                            <div id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                                data-dropdown-placement="bottom-start"
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600 border border-blue-500">
                                <span
                                    class="font-medium text-white dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            {{-- Dropdown Avatar --}}
                            <div id="userDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                {{-- <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div>Bonnie Green</div>
                                    <div class="font-medium truncate">name@flowbite.com</div>
                                </div>
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                    </li>
                                </ul> --}}
                                <div class="py-1">
                                    <a href="{{ route('transactions') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        Transaction
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Sign out
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <div class="font-medium dark:text-white">
                                <div class="text-md">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <!-- Tombol Logout -->
                        {{-- <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg font-medium text-sm transition">
                                Logout
                            </button>
                        </form> --}}
                    </div>
                @endauth


                @guest
                    <button  data-modal-target="loginOptionModal" data-modal-toggle="loginOptionModal"
                        class="border border-black bg-transparent outline-blue-500 px-6 py-2 rounded-lg font-medium text-sm hover:bg-black hover:text-white transition-colors duration-300">
                        Login
                    </button>
                    {{-- <button onclick="register()"
                        class="border border-amber-500 bg-transparent outline-amber-500 px-6 py-2 rounded-lg font-medium text-sm hover:bg-amber-500 hover:text-white transition-colors duration-300">
                        Register
                    </button> --}}
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
    function login() {
        window.location.href = '/login';
    }

    function register() {
        window.location.href = '/register';
    }
</script>
