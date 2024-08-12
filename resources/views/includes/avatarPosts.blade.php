@php
    $nick = $image->user->nick;
    $letterNick = substr($nick, 0, 1);
@endphp

@if($image->user->image)
    <a href="{{ route('profile.viewProfile', ['id' => $image->user->id]) }}">
        <div class="avatar is-post border-bottom-style">
            <img src="{{ asset('instagramUsers/' . $image->user->image) }}" alt="Profile Image" class="avatar avatar-size-medium">
            <div class="avatar-post-name">
                {{ '@' . $image->user->nick . ' • '}} @formatDate($image->created_at)
            </div>
        </div>
    </a>
    @else
    <a href="{{ route('profile.viewProfile', ['id' => $image->user->id]) }}">
        <div class="avatar is-post border-bottom-style">
            <div class="avatar-background-color avatar-size-medium">
                <div class="avatar avatar-letter-small">
                    {{ $letterNick }}
                </div>
            </div>
            <div class="avatar-letter-small">
                {{ $image->user->nick }}
            </div>
        </div>
    </a>
@endif