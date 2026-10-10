<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post Baru</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('posts.store') }}" class="bg-white shadow-sm sm:rounded-lg p-6">
                @include('posts._form')
                <div class="mt-6"><x-primary-button>Simpan</x-primary-button></div>
            </form>
        </div>
    </div>
</x-app-layout>
