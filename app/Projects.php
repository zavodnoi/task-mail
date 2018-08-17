<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Projects extends Model
{
    protected  $guarded = ['id'];
    protected $table = 'projects';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item){
            $item->user_id = auth()->id();
        });
    }
    //
    public function events()
    {
        return $this->hasMany(Events::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
