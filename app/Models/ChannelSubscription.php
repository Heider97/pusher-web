<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelSubscription extends Model
{
    protected $fillable = ['user_id', 'channel_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
