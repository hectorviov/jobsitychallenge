<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entries';

    protected $fillable = [
        'title', 'content', 'user_id'
    ];

    /**
     * Get the user that owns the entry.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
