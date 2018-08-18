<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Events extends Model
{
    protected $table = 'events';

    protected $guarded = ['id'];

    protected $dates = ['started_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->user_id = auth()->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function type()
    {
        return $this->belongsTo(DictionaryTypes::class, 'dictionary_type_id');
    }

    public static function getRoadMap($year, $month)
    {
        $date = Carbon::createFromDate($year, $month);
        $weeks = collect();
        $week_number = 1;
        for ($i = 1; $i <= $date->daysInMonth; $i += Carbon::DAYS_PER_WEEK) {
            Carbon::createFromDate($year, $month, $i);
            $start = Carbon::createFromDate($year, $month, $i)->startOfWeek();
            $end = Carbon::createFromDate($year, $month, $i)->endOfWeek();
            $events = static::whereNull('deleted_at')->
            whereBetween('started_at', [$start, $end])->get()->groupBy('project_id');
            $weeks->put('Неделя #' . $week_number, collect(
                [
                    'start' => 'начало ' . $start->format('d.m.Y'),
                    'end' => 'конец ' . $end->format('d.m.Y'),
                    'events' => $events
                ]
            ));
            $week_number++;
        }

        return $weeks;
    }
}
