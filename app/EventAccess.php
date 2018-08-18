<?php

namespace App;

use App\Events\Event;
use Illuminate\Database\Eloquent\Model;


class EventAccess extends Model
{
    protected $table = 'event_access';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
