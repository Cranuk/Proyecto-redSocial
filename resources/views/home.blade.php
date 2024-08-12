<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-xl mx-auto overflow-hidden">
            <div class="grid grid-cols-1 place-items-center">
                @include('includes.messageAlert')
                @if($images->isNotEmpty())
                    @foreach($images as $image) <!--NOTE: Los datos que usa el include vienen de este foreach-->
                        <div class="my-2 mx-2 bg-slate-800">
                            @include('includes.avatarPosts') <!--NOTE: este include usara los datos del foreach tener cuidado como los manejas-->
                            <a href="{{ route('image.details', ['id' => $image->id]) }}">
                                <img src="{{ asset('instagramPosts/' . $image->image_path) }}" class="py-2 px-2 post-image border-bottom-style" alt="Image">
                            </a>
                            <div class="flex">
                                <div class="post-tools">
                                    @if($data[$image->id]['hasYourLike'])
                                        <img src="{{ asset('images/hearts-red.png') }}" alt="heart-like" class="post-tool-image dislike" data-id={{ $image->id }}>
                                    @else
                                        <img src="{{ asset('images/hearts-white.png') }}" alt="heart-like" class="post-tool-image like" data-id={{ $image->id }}>
                                    @endif
                                </div>
                                <div class="post-tools post-count" id="image{{ $image->id }}">
                                    {{ $data[$image->id]['likes_count'] }}
                                </div>
                                <div class="post-tools">
                                    <a href="{{ route('image.details', ['id' => $image->id]) }}">
                                        <img src="{{ asset('images/comment.png') }}" alt="comment" class="post-tool-image">
                                    </a>
                                </div>
                                <div class="post-tools post-count">
                                    {{ $data[$image->id]['comments_count'] }}
                                </div>
                            </div>
                            <div class="post-comment">
                                <span class="post-user">{{ '@'.$image->user->nick}}</span>&nbsp;&bull;&nbsp;{{ $image->description}}
                            </div>
                        </div>
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
