<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_group_id',
        'activity_id',
        'service_type_id',
        'scheduled_date',
    ];

    public function scheduleGroup()
    {
        return $this->belongsTo(ScheduleGroup::class);
    }

    public function congregants()
    {
        return $this->belongsToMany(Congregant::class, 'congregant_schedules');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
