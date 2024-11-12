@extends('layout')
@section('main')
    <main class="px-8 mt-[3rem]">
        <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
            <div class="relative py-3 sm:max-w-xl sm:mx-auto">
                <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                    <div class="max-w-md mx-auto">
                        <div class="flex items-center space-x-5">
                            <div class="block pl-2 font-semibold text-xl text-gray-700">
                                <h2 class="leading-relaxed">Form Pembayaran</h2>
                                <p class="text-sm text-gray-500 font-normal leading-relaxed">Silahkan isi data diri Anda
                                    untuk melakukan pembayaran</p>
                            </div>
                        </div>

                        <form action="{{ route('processPayment') }}" method="POST" id="payment-form"
                            class="divide-y divide-gray-200">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="py-8 space-y-4">
                                <div class="flex flex-col">
                                    <label for="name" class="text-sm font-medium text-gray-700 mb-1">Nama
                                        Lengkap</label>
                                    <input id="name" type="text" name="name" required
                                        class="border-gray-300 focus:ring-sky-500 focus:border-sky-500 block w-full rounded-md shadow-sm transition duration-150 p-2" />
                                </div>

                                <div class="flex flex-col">
                                    <label for="email" class="text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input id="email" type="email" name="email" required
                                        class="border-gray-300 focus:ring-sky-500 focus:border-sky-500 block w-full rounded-md shadow-sm transition duration-150 p-2" />
                                </div>

                                <div class="flex flex-col">
                                    <label for="address" class="text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <textarea id="address" name="address" required rows="3"
                                        class="border-gray-300 focus:ring-sky-500 focus:border-sky-500 block w-full rounded-md shadow-sm transition duration-150 p-2"></textarea>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="button" id="pay-button"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-150">
                                    Bayar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    @push('scripts')
        <script type="text/javascript">
            document.getElementById("pay-button").addEventListener("click", function(event) {
                event.preventDefault();
                this.disabled = true;
                this.innerText = 'Memproses...';

                fetch('{{ route('processPayment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            product_id: document.getElementById('product_id')
                                .value
                        })
                    })
                    .then(response => {
                        console.log("Respons status:", response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log("Data berhasil diterima:", data);
                        this.disabled = false;
                        this.innerText = 'Bayar Sekarang';

                        // Jika ada data yang valid, lanjutkan ke proses selanjutnya
                        if (data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    console.log("Pembayaran berhasil:", result);
                                    window.location.href = data.redirect_url;
                                },
                                onPending: function(result) {
                                    console.log("Pembayaran pending:", result);
                                    window.location.href = data.redirect_url;
                                },
                                onError: function(result) {
                                    console.error("Pembayaran gagal:", result);
                                    alert('Pembayaran gagal!');
                                },
                                onClose: function() {
                                    console.log("Pembayaran ditutup tanpa selesai.");
                                    alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                                }
                            });
                        } else {
                            alert("Terjadi masalah pada respons server.");
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan saat mengirim request:", error);
                        this.disabled = false;
                        this.innerText = 'Bayar Sekarang';
                        alert('Terjadi kesalahan! Silakan coba lagi.');
                    });
            });
        </script>
    @endsection
