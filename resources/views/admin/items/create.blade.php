<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Tambah Barang') }}
                    </h2>

                    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block font-semibold">Nama Barang</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="block font-semibold">Kategori Barang</label>
                            <input type="text" name="category" id="category" value="{{ old('category') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block font-semibold">Harga Barang</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            @error('price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label for="quantity" class="block font-semibold">Jumlah Barang</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            @error('quantity')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div class="mb-4">
                            <label for="photo" class="block font-semibold">Foto Barang</label>
                            <input type="file" name="photo" id="photo"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @error('photo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <x-button>
                                Simpan Barang
                            </x-button>

                            <a class="underline text-sm text-gray-600 hover:text-gray-900 ml-4"
                                href="{{ route('admin.items.index') }}">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
