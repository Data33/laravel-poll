<?php

namespace Data33\LaravelPoll\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pollvotes';

    protected $dates = ['created_at'];

    protected $fillable = ['polloption_id', 'voter_id'];

    /**
     * A PollVote belongs to a Poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    /**
     * A PollVote belongs to a PollOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function polloption() {
        return $this->belongsTo(PollOption::class);
    }

    /**
     * A PollVote belongs to a Voter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voter() {
        $model = config('polls.models.voter');

        return $this->belongsTo($model, 'voter_id');
    }
}
