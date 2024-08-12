<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- NOTE: imagen de la publicacion-->
                    <div class="my-2 mx-2 bg-slate-800">
                        <img src="{{ asset('instagramPosts/' . $image->image_path) }}" class="py-2 px-2 post-image border-bottom-style" alt="Image">
                    </div>
                    <form method="post" action="{{ Route('image.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-text-input id="id" name="id" type="hidden" value="{{ $image->id }}"/>
                        </div>
                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                
                        <div>
                            <x-input-label for="Description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $image->description)" autofocus autocomplete="description" />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>