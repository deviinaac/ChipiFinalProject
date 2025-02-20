<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif


                <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}"
                    class="w-full h-64 object-cover rounded-md mb-6">

                <h1 class="text-3xl font-bold mb-2">{{ $item->name }}</h1>
                <p class="text-gray-600 text-lg mb-4">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mb-4">Stok: {{ $item->quantity }}</p>
                <p class="mb-6">Kategori: {{ $item->category }}</p>

                <form action="{{ route('cart.add', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Tambah ke Keranjang
                    </button>

                    <a href="{{ route('user.items.index') }}" class="ml-2 text-blue-500 hover:underline">
                        Kembali ke Belanja
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
