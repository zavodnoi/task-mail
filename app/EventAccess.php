<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EventAccess extends Model
{
    const ACCESS_READ = 'read';
    const ACCESS_EDIT = 'edit';

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
