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
                    You're logged in!

                    <!-- Role-Based Button -->
                    <div class="mt-6">
                        @if (Auth::user()->role === 'admin')
                            <x-button>
                                <a href={{ route('admin.items.index') }}>
                                    Kelola Barang
                                </a>
                            </x-button>
                        @else
                            <x-button>
                                <a href={{ route('user.items.index') }}>
                                    Belanja Barang
                                </a>
                            </x-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
