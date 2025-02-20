<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Table Barang') }}
                    </h2>

                    <!-- Add Button -->
                    <x-button class="mb-4">
                        <a href="{{ route('admin.items.create') }}">
                            + Tambah Barang
                        </a>
                    </x-button>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg shadow-md overflow-hidden">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-2">ID Barang</th>
                                    <th class="px-4 py-2">Nama Barang</th>
                                    <th class="px-4 py-2">Harga Barang</th>
                                    <th class="px-4 py-2">Jumlah Barang</th>
                                    <th class="px-4 py-2">Foto Barang</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="border-b hover:bg-gray-100">
                                        <td class="px-4 py-2">{{ $item->id }}</td>
                                        <td class="px-4 py-2">{{ $item->name }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="px-4 py-2">
                                            @if ($item->photo)
                                                <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto Barang"
                                                    class="h-20 w-20 rounded-md">
                                            @else
                                                <span class="text-gray-500">No Image</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class=" flex items-center justify-center gap-4">
                                                <x-button class="mr-2">
                                                    <a href="{{ route('admin.items.edit', $item->id) }}">
                                                        Update
                                                    </a>
                                                </x-button>

                                                <form action="{{ route('admin.items.destroy', $item->id) }}"
                                                    method="POST" class="inline" id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="button"
                                                        onclick="confirmDelete({{ $item->id }})">
                                                        Delete
                                                    </x-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($items->isEmpty())
                            <p class="text-center text-gray-500 py-4">Tidak ada barang yang tersedia.</p>
                        @endif
                    </div>
                </div>

                <!-- JavaScript Confirmation -->
                <script>
                    function confirmDelete(itemId) {
                        if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
                            document.getElementById('delete-form-' + itemId).submit();
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
