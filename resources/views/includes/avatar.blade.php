@php
    $nick = Auth::user()->nick;
    $letterNick = substr($nick,0,1);
@endphp

@if(Auth::user()->image)
    <img src="{{ asset('instagramUsers/' . Auth::user()->image) }}" alt="Profile Image" class="avatar-size-medium" title="{{ Auth::user()->nick }}">
@else
    <div class="avatar avatar-size-medium avatar-background-color">
        <div class="avatar-letter">
            {{ $letterNick }}
        </div>
    </div>
@endif
