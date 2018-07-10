<?php

namespace Data33\LaravelPoll\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'polloptions';

    protected $dates = ['created_at'];

    protected $fillable = ['text'];

    /**
     * A PollOption belongs to a Poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    /**
     * A PollOption has many Votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes() {
        return $this->hasMany(PollVote::class, 'polloption_id');
    }
}
