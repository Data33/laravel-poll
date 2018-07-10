<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Here we specify the model classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */
    'models' => [
        'poll' => Data33\LaravelPoll\Models\Poll::class,
        'polloption' => Data33\LaravelPoll\Models\PollOption::class,
        'vote' => Data33\LaravelPoll\Models\PollVote::class,
        'voter' => App\User::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    |
    | Here we specify the views to use. Change these if you want to change the
    | output of the Poll model's render method
    |
    */
    'views' => [
        'poll' => 'vendor.data33.laravel-poll.poll',
    ]
];