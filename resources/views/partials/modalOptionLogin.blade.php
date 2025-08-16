<!-- Main modal -->
<div id="loginOptionModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[100vh] flex justify-center items-center bg-black/50">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Pilih Opsi Login
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="loginOptionModal">
                    ✕
                </button>
            </div>
            <!-- Body -->
            <div class="p-6 flex flex-col gap-4">
                <!-- Login Tamu -->
                <a href="{{ route('login') }}"
                    class="w-full px-4 py-3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                    Login sebagai Tamu
                </a>

                <!-- Login Pemilik Kos -->
                <a href="/admin"
                    class="w-full px-4 py-3 text-center bg-primary hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    Login sebagai Pemilik Kos
                </a>
            </div>
        </div>
    </div>
</div>
