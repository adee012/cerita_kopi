@extends('layout')
@section('main')
    <main class="px-8 mt-[6rem]">
        <h1 class="font-medium text-lg">Keranjang Belanja</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (empty($cart))
            <p>Keranjang Anda kosong.</p>
        @else
            <table class="table-auto w-full mt-5">
                <thead>
                    <tr>
                        <th class="text-left">Produk</th>
                        <th class="text-left">Jumlah</th>
                        <th class="text-left">Harga</th>
                        <th class="text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['price']) }}</td>
                            <td>Rp {{ number_format($item['price'] * $item['quantity']) }}</td>
                        </tr>
                        @php $total += $item['price'] * $item['quantity']; @endphp
                    @endforeach
                    <tr>
                        <td colspan="3" class="font-semibold">Total</td>
                        <td>Rp {{ number_format($total) }}</td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('checkout') }}" method="POST" class="mt-5">
                @csrf
                <button type="submit"
                    class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-500 transition duration-300">
                    Checkout
                </button>
            </form>
        @endif
    </main>
@endsection
