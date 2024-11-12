<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Kopi</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    {{-- css --}}
    @vite('resources/css/app.css')

    {{-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script> --}}

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-D1gL9VqCBFwqjcRl"></script>


</head>

<body>
    <header class="flex justify-between p-8 items-center fixed top-0 left-0 w-full bg-white z-50">
        <div class="logo">
            <img src="{{ asset('assets/images/CERITA KOPI.png') }}" alt="" class="w-[140px]">
        </div>

        <div class="navigasi text-base font-medium flex gap-4">
            <ul class="flex gap-4">
                <li>
                    <a href="{{ route('/') }}"
                        class="{{ Request::is('/') ? 'text-green-600 font-bold' : 'text-black' }}">
                        Home
                    </a>
                </li>

                <!-- Product link -->
                <li>
                    <a href="{{ route('products') }}"
                        class="{{ Request::is('products') ? 'text-sky-400 font-bold' : 'text-black' }}">
                        Product
                    </a>
                </li>

                <!-- About link -->
                {{-- <li>
                    <a href="{{ route('about') }}" class="{{ Request::is('about') ? 'text-green-600 font-bold' : 'text-gray-600' }}">
                        About
                    </a>
                </li> --}}
            </ul>

            {{-- <a href="{{ route('cart') }}" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-black hover:text-sky-400 transition duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5H21m-5 8a3 3 0 11-6 0m6 0a3 3 0 11-6 0m-3 4h6" />
                </svg>
                <!-- Item count badge (optional) -->
                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full px-1">
                    @php $jumlah = 0; @endphp
                    @foreach ($cart as $item)
                        @php $jumlah +=  $item['quantity']; @endphp
                    @endforeach
                </span> --}}
            </a>
        </div>
    </header>

    @yield('main')
    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
