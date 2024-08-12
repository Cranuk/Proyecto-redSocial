<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-xl mx-auto overflow-hidden">
            <form method="get" action="{{ route('profile.list')}}" id="form-search">
                @csrf
                <div>
                    <x-text-input id="search" type="text" class="mt-1 block w-full" autofocus />
                </div>

                <div class="flex items-center space-10">
                    <x-primary-button>{{ __('Search') }}</x-primary-button>
                </div>
            </form>
            <div class="grid grid-cols-1 place-items-center">
                @foreach($users as $user) <!--NOTE: Los datos que usa el include vienen de este foreach-->
                    <div class="my-2 mx-2 bg-slate-800 w-500">
                        @include('includes.userProfile')
                        <div class="btn-info">
                            <a href="{{ route('profile.viewProfile', ['id' => $user->id]) }}"> View profile</a>
                        </div>
                    </div>
                    
                @endforeach
            </div>
            <div class="post-pagination">
                {{ $users->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
