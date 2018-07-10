<div class="laravel-poll">
    @if (!$poll->isClosed())
        @include('vendor.data33.laravel-poll.vote')
    @else
        @include('vendor.data33.laravel-poll.results')
    @endif
</div>