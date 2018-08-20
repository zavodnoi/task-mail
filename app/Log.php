<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{
    protected $guarded = ['id'];
    protected $table = 'logs';

    //
    public static function add($resource_id)
    {
        $route_as = \Route::getCurrentRoute()->getName();
        static::create([
            'action' => $route_as,
            'user_id' => auth()->id(),
            'resource_id' => $resource_id,
        ]);

    }

}
