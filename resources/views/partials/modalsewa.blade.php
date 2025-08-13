<!-- Modal Sewa -->
<div id="modalSewa" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
        <!-- Tombol Close -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            ✕
        </button>

        <h3 class="text-xl font-bold mb-4 text-blue-600">Form Sewa Kamar</h3>
        <form method="POST" action="{{ route('sewa') }}" id="sewaForm">
            @csrf
            <input type="text" id="room_id" name="room_id" value="{{ $room->id }}" hidden>
            <input type="text" id="user_id" name="user_id" value="{{ Auth::id() }}" hidden>
            <!-- Durasi -->
            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (bulan)</label>
                <input type="number" id="duration" name="duration" min="1" value="1"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tanggal Masuk -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                <input type="date" id="start_date" name="start_date"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tanggal Keluar -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                <input type="date" id="end_date" name="end_date" readonly
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 bg-gray-100 text-gray-500">
            </div>

            <div class="mb-4">
                <label for="price_per_month" class="block text-sm font-medium text-gray-700">Harga Per Bulan</label>
                <input type="text" id="price_per_month" name="price_per_month" disabled
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="total_price" class="block text-sm font-medium text-gray-700">Harga Total</label>
                <input type="text" id="total_price" name="total_price"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" id="pay-button"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-md">
                    Sewa Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const durasiInput = document.getElementById('duration');
        const tanggalMasukInput = document.getElementById('start_date');
        const tanggalKeluarInput = document.getElementById('end_date');
        const pricePerMonthInput = document.getElementById('price_per_month');
        const priceTotalInput = document.getElementById('total_price');

        // Fungsi untuk menghitung tanggal keluar
        function hitungTanggalKeluar() {
            const tanggalMasuk = new Date(tanggalMasukInput.value);
            const durasi = parseInt(durasiInput.value);
            const tanggalKeluar = new Date(tanggalMasuk);
            tanggalKeluar.setMonth(tanggalMasuk.getMonth() + durasi);
            tanggalKeluarInput.value = tanggalKeluar.toISOString().split('T')[0];
        }

        // Fungsi untuk menghitung harga total
        function hitungHargaTotal() {
            const durasi = parseInt(durasiInput.value);
            const pricePerMonth = parseFloat(pricePerMonthInput.value.replace(/[^0-9.-]+/g, ""));
            if (!isNaN(durasi) && !isNaN(pricePerMonth)) {
                const total = durasi * pricePerMonth;
                priceTotalInput.value = total;
            } else {
                priceTotalInput.value = '';
            }
        }

        // Event listener untuk input durasi
        durasiInput.addEventListener('input', hitungTanggalKeluar);
        durasiInput.addEventListener('input', hitungHargaTotal);

        // Event listener untuk input tanggal masuk
        tanggalMasukInput.addEventListener('input', hitungTanggalKeluar);
        tanggalMasukInput.addEventListener('input', hitungHargaTotal);

        // Event listener untuk input harga per bulan
        pricePerMonthInput.addEventListener('input', hitungHargaTotal);
    });

    // Fungsi untuk menghitung harga total
    // function hitungHargaTotal() {
    //     const durasi = parseInt(durasiInput.value);
    //     const pricePerMonth = parseFloat(pricePerMonthInput.value.replace(/[^0-9.-]+/g, ""));
    //     if (!isNaN(durasi) && !isNaN(pricePerMonth)) {
    //         const total = durasi * pricePerMonth;
    //         priceTotalInput.value = total.toLocaleString('id-ID', {
    //             style: 'currency',
    //             currency: 'IDR'
    //         });
    //     } else {
    //         priceTotalInput.value = '';
    //     }
    // }
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
document.getElementById('pay-button').onclick = function(e) {
    e.preventDefault();
    let form = document.getElementById('sewaForm');
    let formData = new FormData(form);

    // Pastikan total_price dikirim sebagai angka (integer)
    let totalPriceRaw = document.getElementById('total_price').value.replace(/[^0-9]/g, '');
    formData.set('total_price', totalPriceRaw);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token);
        } else {
            alert('Gagal mendapatkan SnapToken');
            console.log(data);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan pembayaran');
        console.error(error);
    });
};
</script>
