<?php

namespace Data33\LaravelPoll\Models;

use Carbon\Carbon;
use Data33\LaravelPoll\Exceptions\InvalidPollTypeException;
use Data33\LaravelPoll\Exceptions\InvalidVoterException;
use Data33\LaravelPoll\Traits\Voter;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    const TYPE_SINGLE = 0;
    const TYPE_MULTIPLE = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'polls';

    protected $dates = ['created_at', 'closes_at'];

    protected $fillable = ['title', 'text', 'closes_at', 'type', 'closed'];

    /**
     * A Poll has many options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options() {
        return $this->hasMany(PollOption::class);
    }

    /**
     * A Poll has many votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes() {
        return $this->hasMany(PollVote::class);
    }

    /**
     * Helper method for adding more options to a Poll
     *
     * @param $text
     * @return $this
     */
    public function addOption($text) {
        $pollOptionClass = config('polls.models.polloption');

        $this->options()
            ->save(new $pollOptionClass([
                'text' => $text,
            ]));

        return $this;
    }

    /**
     * Check if a Poll is closed, either manually or by passed deadline
     *
     * @return bool
     */
    public function isClosed() {
        return $this->closed || Carbon::now() > $this->closes_at;
    }

    /**
     * Returns HTML for rendering the Poll
     *
     * @param null $voter
     * @return mixed
     */
    public function render($voter = null) {
        $this->validateVoter($voter);

        return view(config('polls.views.poll'), ['poll' => $this, 'voter' => $voter])->render();
    }

    /**
     * Returns a result object with calculated percentages and number of votes
     *
     * @param null $voter
     * @return object
     */
    public function results($voter = null) {
        $this->validateVoter($voter);
        $options = [];

        $this->load('options.votes');

        $numVotes = 0;
        foreach ($this->options as $option) {
            $numVotes += $option->votes->count();
        }

        foreach ($this->options as $option) {
            $votesCount = $option->votes->count();
            $options[] = (object)[
                'text' => $option->text,
                'votes' => $votesCount,
                'percentage' => $numVotes > 0 ? round(($votesCount / $numVotes) * 100) : 0,
                'checked' => $voter !== null && $voter->hasVotedForOption($this, $option),
                'model' => $option,
            ];
        }

        return (object)[
            'options' => $options,
            'votes' => $numVotes
        ];
    }

    /**
     * Helper method for creating Polls
     *
     * @param $title
     * @param $text
     * @param int $type
     * @param array $options
     * @param null $endDate
     * @return mixed
     * @throws InvalidPollTypeException
     */
    public static function createPoll($title, $text, $type = self::TYPE_SINGLE, $options = [], $endDate = null) {
        $pollClass = config('polls.models.poll');
        $pollOptionClass = config('polls.models.polloption');

        if ($endDate !== null && !($endDate instanceof Carbon)) {
            $endDate = new Carbon($endDate);
        }

        if (!in_array($type, [self::TYPE_SINGLE, self::TYPE_MULTIPLE])) {
            throw new InvalidPollTypeException;
        }

        $poll = new $pollClass([
            'type' => $type,
            'title' => $title,
            'text' => $text,
            'closes_at' => $endDate,
        ]);
        $poll->save();

        foreach ($options as $option) {
            $poll->options()
                ->save(new $pollOptionClass([
                    'text' => $option,
                ]));
        }

        return $poll;
    }

    /**
     * Validates a given argument to see that it actually uses the Voter trait
     *
     * @param $voter
     * @return bool
     * @throws InvalidVoterException
     */
    private function validateVoter($voter) {
        if ($voter === null)    return true;

        $traits = class_uses($voter);
        if (in_array(Voter::class, $traits))    return true;

        throw new InvalidVoterException;
    }
}
