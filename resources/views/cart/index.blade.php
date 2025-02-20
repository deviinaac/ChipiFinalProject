<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif

                @if (count($cartItems) > 0)
                    <table class="table-auto w-full mb-6">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Foto</th>
                                <th class="border px-4 py-2">Nama Barang</th>
                                <th class="border px-4 py-2">Harga (Terbaru)</th>
                                <th class="border px-4 py-2">Jumlah</th>
                                <th class="border px-4 py-2">Total</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp

                            @foreach ($cartItems as $item)
                                @php
                                    $total = $item['price'] * $item['quantity'];
                                    $grandTotal += $total;
                                @endphp

                                <tr>
                                    <td class="border px-4 py-2">
                                        <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['name'] }}"
                                            class="h-12 w-12 rounded">
                                    </td>
                                    <td class="border px-4 py-2">{{ $item['name'] }}</td>
                                    <td class="border px-4 py-2">Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="1" class="w-16 border rounded">
                                            <button type="submit"
                                                class="ml-2 bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                                        </form>
                                    </td>
                                    <td class="border px-4 py-2">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Grand Total -->
                    <div class="mb-4 text-lg font-bold">
                        Grand Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </div>

                    <!-- Cetak Faktur Button -->
                    @if (count($cartItems) > 0)
                        <form action="{{ route('cart.invoice') }}" method="POST" target="_blank">
                            @csrf

                            <!-- Alamat Pengiriman -->
                            <div class="mb-4">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700">Alamat
                                    Pengiriman</label>
                                <input type="text" name="shipping_address" id="shipping_address"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    placeholder="Masukkan alamat pengiriman" required
                                    value="{{ old('shipping_address') }}">
                                @error('shipping_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Pos -->
                            <div class="mb-6">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode
                                    Pos</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    placeholder="Masukkan kode pos" required value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Cetak Faktur
                            </button>
                        </form>
                    @endif

                    <!-- Clear Cart Form (Separate Form) -->
                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                            Kosongkan Keranjang
                        </button>
                    </form>
                @else
                    <p class="text-gray-600">Keranjang belanja Anda kosong.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
