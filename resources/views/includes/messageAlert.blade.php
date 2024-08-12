<div class="alert-box">
    @if (session('status'))
        <div x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>