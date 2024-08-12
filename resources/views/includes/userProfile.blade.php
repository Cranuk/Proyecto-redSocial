<div class="border-bottom-style">
    <div class="user">
        @include('includes.otherProfile')
        <div class="info">
            {{ $user->name }}
            {{ $user->surname }} <br>
            <div class="nick">
                <span>@</span>{{ $user->nick }}
            </div>
        </div>
    </div>
</div>