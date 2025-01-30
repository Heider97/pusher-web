<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissedMessage extends Model
{
    protected $fillable = ['user_id', 'channel_id', 'message', 'sent'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
