<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * Get the schedule group.
     */
    public function scheduleGroup(): BelongsTo
    {
        return $this->belongsTo(ScheduleGroup::class);
    }

    /**
     * Get the congregants.
     */
    public function congregants(): BelongsToMany
    {
        return $this->belongsToMany(Congregant::class, 'congregant_schedules');
    }

    /**
     * Get the activity.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the service type.
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }
}
