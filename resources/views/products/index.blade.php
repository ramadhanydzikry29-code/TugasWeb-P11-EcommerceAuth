<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Katalog Produk</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="mb-6 flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                       class="border-gray-300 rounded-md shadow-sm w-72">
                <x-primary-button>Cari</x-primary-button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($products as $product)
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-xs uppercase text-gray-400">{{ $product->category->name }}</p>
                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                        <p class="mt-2 text-lg font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Produk tidak ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
