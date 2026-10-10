<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Produk</p>
                <p class="text-2xl font-bold">{{ $productCount }}</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Order</p>
                <p class="text-2xl font-bold">{{ $orderCount }}</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5 col-span-2">
                <p class="text-sm text-gray-500">Omzet (paid/shipped/completed)</p>
                <p class="text-2xl font-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5 col-span-2 md:col-span-4">
                <p class="text-sm text-gray-500 mb-2">User per role</p>
                @foreach ($usersByRole as $role => $total)
                    <span class="inline-block mr-3 px-3 py-1 bg-gray-100 rounded">{{ $role }}: {{ $total }}</span>
                @endforeach
                <p class="mt-4 text-sm"><a class="text-blue-600" href="{{ route('admin.demo.eager') }}">Demo eager vs lazy loading (JSON)</a></p>
            </div>
        </div>
    </div>
</x-app-layout>
