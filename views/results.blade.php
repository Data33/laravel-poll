<h3>{{ $poll->title }}</h3>
<small>{{ $poll->text }}</small>
@if ($poll->closes_at !== null)
    <div class="laravel-poll-date">Closed at: {{ $poll->closes_at->format('Y-m-d') }}</div>
@endif

@php
$results = $poll->results($voter);
@endphp
@foreach ($results->options as $option)
    <div class='result-option'>
        <strong>{{ $option->text }}</strong><span class='pull-right'>{{ $option->percentage }}% ({{ $option->votes }})</span>
        @if ($voter->hasVotedForOption($poll, $option->model))
            <i>You voted for this</i>
        @endif
        <div class='progress'>
            <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='{{ $option->percentage }}' aria-valuemin='0' aria-valuemax='100' style='width: {{ $option->percentage }}%'>
                <span class='sr-only'>{{ $option->percentage }}% Complete</span>
            </div>
        </div>
    </div>
@endforeach