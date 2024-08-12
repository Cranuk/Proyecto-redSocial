<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Image') }}
        </h2>
    </x-slot>
    @include('includes.userProfile')
    <div class="py-12">
        <div class="max-w-screen-xl mx-auto overflow-hidden">
            <div class="grid grid-cols-4 place-items-center">
                @if($images->isNotEmpty())
                    @foreach($images as $image)
                        <a href="{{ route('image.details', ['id' => $image->id]) }}">
                            <img src="{{ asset('instagramPosts/' . $image->image_path) }}" class="py-2 px-2 post-image-like" alt="Image">
                        </a>
                    @endforeach
                @else
                    <p>No images found.</p>
                @endif
            </div>
            <div class="post-pagination">
                {{ $images->links()}}
            </div>
        </div>
    </div>
</x-app-layout>