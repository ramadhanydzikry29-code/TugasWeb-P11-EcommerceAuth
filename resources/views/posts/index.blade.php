<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}"
                   class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md">+ Post Baru</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            @forelse ($posts as $post)
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <a href="{{ route('posts.show', $post) }}" class="text-lg font-semibold text-gray-900 hover:underline">
                        {{ $post->title }}
                    </a>
                    <p class="text-sm text-gray-500">oleh {{ $post->author->name }} &middot; {{ $post->created_at->diffForHumans() }}</p>

                    <div class="mt-3 flex gap-3">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="text-sm text-blue-600">Edit</a>
                        @endcan
                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                  onsubmit="return confirm('Hapus post ini?')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-600">Hapus</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada post.</p>
            @endforelse

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
