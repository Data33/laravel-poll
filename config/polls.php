<?php
return [
    'models' => [
        'poll' => Data33\LaravelPoll\Models\Poll::class,
        'polloption' => Data33\LaravelPoll\Models\PollOption::class,
        'vote' => Data33\LaravelPoll\Models\PollVote::class,
        'voter' => App\User::class,
    ],
    'views' => [
        'poll' => 'vendor.data33.laravel-poll.poll',
    ]
];