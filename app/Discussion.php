<?php

namespace App;

use App\Reply;
use App\Notifications\ReplyMarkedAsBestReply;

class Discussion extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function scopeFilterByChannels($builder)
    {
        if (request()->query('channel')) {
            
            $channel = Channel::where('slug', request()->query('channel'))->first();

            if ($channel) {

                return $builder->where('channel_id', $channel->id);
            }

            return $builder;

        }

        return $builder;

    }

    public function scopeFilterByLoginAuthor($builder)
    {
        if (request()->query('author')) {
            
            $user = User::where('id', request()->query('author'))->first();

            if ($user) {

                return $builder->where('user_id', $user->id);
            }

            return $builder;

        }

        return $builder;

    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getBestReply()
    {
        return $this::find($this->reply_id);
    }

    public function bestReply()
    {
        return $this->belongsTo(Reply::class, 'reply_id');
    }

    public function markAsBestReply(Reply $reply)
    {
        $this->update([
            'reply_id' => $reply->id
        ]);

        if ($reply->owner->id === $this->author->id) {
            return;
        }

        $reply->owner->notify(new ReplyMarkedAsBestReply($reply->discussion));
    }

    public function removeBestReply(Reply $reply)
    {
        $this->update([
            'reply_id' => 0
        ]);

    }

}
