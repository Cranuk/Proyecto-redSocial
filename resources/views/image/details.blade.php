<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-xl mx-auto overflow-hidden">
            <div class="grid grid-cols-1 place-items-center">
                @if($image)
                    <div class="my-2 mx-2 bg-slate-800">
                        @include('includes.avatarPosts') <!--NOTE: Los datos que usa el include vienen de este foreach-->
                        <!-- NOTE: imagen de la publicacion-->
                        <img src="{{ asset('instagramPosts/' . $image->image_path) }}" class="py-2 px-2 post-image border-bottom-style" alt="Image">

                        <!-- NOTE: herramientas para la interaccion de la publicacion-->
                        <div class="flex">
                            <div class="post-tools">
                                @if($dataImage)
                                    <img src="{{ asset('images/hearts-red.png') }}" alt="heart-like" class="post-tool-image dislike" data-id={{ $image->id }}>
                                @else
                                    <img src="{{ asset('images/hearts-white.png') }}" alt="heart-like" class="post-tool-image like" data-id={{ $image->id }}>
                                @endif
                                
                            </div>
                            <div class="post-tools post-count" id="image{{ $image->id }}">
                                @countLikes($image->id)
                            </div>
                            <div class="post-tools">
                                <img src="{{ asset('images/comment.png') }}" alt="comment" class="post-tool-image">
                            </div>
                            <div class="post-tools post-count">
                                @countComments($image->id)
                            </div>
                            <!--NOTE: agregamos herramientas de borrado y edicion siempre y cuando seas quien subio la imagen-->
                            @if(Auth::user() && Auth::user()->id == $image->user_id)
                                <div class="post-tools action-tool">
                                    <a href="{{ route('image.edit',['id' => $image->id]) }}">
                                        <img src="{{ asset('images/edit.png') }}" alt="edit-image" class="post-tool-image-2">
                                    </a>
                                    <a href="{{ route('image.delete',['id' => $image->id]) }}">
                                        <img src="{{ asset('images/trash.png') }}" alt="delete-image" class="post-tool-image-2">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="post-comment">
                            <span class="post-user">{{ '@'.$image->user->nick}}</span>&nbsp;&bull;&nbsp;{{ $image->description}}
                        </div>

                        <!-- NOTE: seccion de comentarios de la publicacion-->
                        @foreach($comments as $comment)
                            <div class="post-comment">
                                <div class="flex">
                                    <span class="post-user">
                                        {{ '@'.$comment->user->nick}}
                                    </span>
                                    &nbsp;&bull;&nbsp;
                                    @formatDate($comment->created_at)
                                    &nbsp;&bull;&nbsp;

                                    @if(Auth::user() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $comment->image->user_id))
                                        <a href="{{ route('comment.delete',['id' => $comment->id]) }}">
                                            <img src="{{ asset('images/trash.png') }}" alt="delete-comment" class="post-tool-image">
                                        </a>
                                    @endif
                                </div>

                                {{ $comment->content }}
                                
                            </div>
                        @endforeach

                        <hr class="line-space">

                        <form method="post" action="{{ route('comment.save')}}" class="is-post">
                            @csrf
                            <div>
                                <x-text-input id="image_id" name="image_id" type="hidden" value="{{ $image->id }}" /> 
                            </div>
                            <div>
                                <x-text-input id="content" name="content" type="text" class="mt-1 block w-full" required autofocus autocomplete="content" />
                            </div>

                            <div class="flex items-center space-10">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>

                    </div>
                @else
                    <p>No images found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
