<h3>{{ $poll->title }}</h3>
<small>{{ $poll->text }}</small>
@if ($poll->closes_at !== null)
    <div class="laravel-poll-date">Closes at: {{ $poll->closes_at->format('Y-m-d') }}</div>
@endif

@if ($poll->type === Data33\LaravelPoll\Models\Poll::TYPE_SINGLE)
    @foreach ($poll->options as $option)
        <div class="radio">
            <label>
                <input type="radio"
                       name="poll_{{ $poll->id }}[]"
                       value="{{ $option->id }}"
                       @if ($voter !== null && $voter->hasVotedForOption($poll, $option))
                       checked="checked"
                       @elseif ($voter === null)
                       disabled="disabled"
                       @endif
                >
                {{ $option->text }}
            </label>
        </div>
    @endforeach
@else
    @foreach ($poll->options as $option)
        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="poll_{{ $poll->id }}[]"
                       value="{{ $option->id }}"
                       @if ($voter !== null && $voter->hasVotedForOption($poll, $option))
                       checked="checked"
                       @elseif ($voter === null)
                       disabled="disabled"
                        @endif
                >
                {{ $option->text }}
            </label>
        </div>
    @endforeach
@endif