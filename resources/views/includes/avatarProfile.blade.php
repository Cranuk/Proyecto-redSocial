@php
    $nick = Auth::user()->nick;
    $letterNick = substr($nick,0,1);
@endphp

@if(Auth::user()->image)
    <img src="{{ asset('instagramUsers/' . Auth::user()->image) }}" alt="Profile Image" class="avatar-size-big">
@else
    <div class="avatar avatar-background-color avatar-size-big">
        <div class="avatar-letter-big">
            {{ $letterNick }}
        </div>
    </div>
@endif
