@php
    $nick = $user->nick;
    $letterNick = substr($nick,0,1);
@endphp

@if($user->image)
    <img src="{{ asset('instagramUsers/' . $user->image) }}" alt="Profile Image" class="avatar-size-big">
@else
    <div class="avatar avatar-background-color avatar-size-big">
        <div class="avatar-letter-big">
            {{ $letterNick }}
        </div>
    </div>
@endif