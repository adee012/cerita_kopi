@extends('layout')
@section('main')
    <main class="px-8 mt-[6rem]">
        <h1 class="font-medium text-lg">Menu Cerita Kopi...</h1>
        <p class="text-sm font-light">Kopi pilihan untuk teman cerita kopi</p>

        <ul class="mt-10 flex gap-4 text-base font-medium">
            <li class="underline">Minuman</li>
            <li class="underline">Makanan</li>
        </ul>
        <section class="mt-3 grid grid-cols-5 gap-4">
            {{-- product card --}}
            @forelse ($products as $product)
                <div class="card border rounded-lg overflow-hidden shadow-lg p-4 flex flex-col items-left">
                    <img src="{{ asset('storage') }}/{{ $product->image }}" alt="" class="w-full h-48 object-cover">

                    <h3 class="text-base font-medium mt-3">{{ $product->product_name }}</h3>
                    <p class="text-xs font-light text-gray-600">{{ $product->product_description }}</p>

                    <div class="mt-3 w-full flex justify-between items-center">
                        <button type="button"
                            onclick="window.location.href='{{ route('checkout', ['productId' => $product->id]) }}'"
                            class="text-md font-medium bg-sky-400 text-white py-1 px-2 rounded hover:bg-sky-300 transition duration-300">
                            Beli
                        </button>

                        <span class="text-md font-medium">Rp {{ number_format($product->price) }}</span>
                    </div>
                </div>
            @empty
                <h1 class="text-center">Belum Ada Data Product</h1>
            @endforelse

        </section>

    </main>
@endsection
