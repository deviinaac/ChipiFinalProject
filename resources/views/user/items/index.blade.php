<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Belanja Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}"
                            class="w-full h-48 object-cover">

                        <div class="p-4">
                            <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
                            <p class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Stok: {{ $item->quantity }}</p>

                            <div class="mt-4">
                                <a href="{{ route('user.items.show', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($items->isEmpty())
                <p class="text-center text-gray-500 mt-6">Tidak ada barang yang tersedia.</p>
            @endif
        </div>
    </div>
</x-app-layout>
