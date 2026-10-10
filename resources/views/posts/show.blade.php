<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500 mb-4">oleh {{ $post->author->name }} &middot; {{ $post->created_at->format('d M Y') }}</p>
                <div class="whitespace-pre-line text-gray-800">{{ $post->body }}</div>
                <a href="{{ route('posts.index') }}" class="inline-block mt-6 text-sm text-blue-600">&larr; Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
