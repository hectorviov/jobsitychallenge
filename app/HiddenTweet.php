<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiddenTweet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hidden_tweets';

    /**
     * Get the user who hid the tweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
