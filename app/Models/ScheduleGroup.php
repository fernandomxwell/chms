<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity_id',
        'start_date',
        'end_date',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
