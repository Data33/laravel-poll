<?php
namespace Data33\LaravelPoll\Traits;


use Data33\LaravelPoll\Exceptions\PollIsClosedException;
use Data33\LaravelPoll\Exceptions\InvalidPollException;
use Data33\LaravelPoll\Exceptions\InvalidPollOptionException;
use Data33\LaravelPoll\Models\Poll;
use Data33\LaravelPoll\Models\PollOption;
use Illuminate\Database\Eloquent\Model;

trait Voter
{
    public function voteFor(Poll $poll, $options) {
        $pollClass = config('polls.models.poll');
        $pollOptionClass = config('polls.models.polloption');
        $pollVoteClass = config('polls.models.vote');

        if ($poll->isClosed()) {
            throw new PollIsClosedException;
        }

        if (!($poll instanceof $pollClass)) {
            throw new InvalidPollException;
        }

        if ($options instanceof Model) {
            $options = collect($options);
        }

        $optionModels = [];
        foreach ($options as $option) {
            if (!($option instanceof $pollOptionClass)) {
                throw new InvalidPollOptionException;
            }

            $optionModels[] = $option;

            if ($poll->type === Poll::TYPE_SINGLE)  break;
        }

        $poll->votes()
            ->where('voter_id', '=', $this->id)
            ->delete();

        foreach ($optionModels as $option) {
            $poll->votes()
                ->save(new $pollVoteClass([
                    'voter_id' => $this->id,
                    'polloption_id' => $option->id,
                ]));
        }

        return true;
    }

    public function hasVotedInPoll(Poll $poll) {
        return $poll->votes
            ->where('voter_id', $this->id)
            ->isNotEmpty();
    }

    public function hasVotedForOption(Poll $poll, PollOption $option) {
        return $poll->votes
            ->where('voter_id', $this->id)
            ->where('polloption_id', $option->id)
            ->isNotEmpty();
    }
}