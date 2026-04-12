<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use Searchable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'start_time',
        'rrule',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
    ];

    /**
     * Get the searchable attributes
     */
    public function getSearchable(): array
    {
        return [
            'name',
        ];
    }

    /**
     * Get the schedule groups.
     *
     * @return HasMany
     */
    public function scheduleGroups()
    {
        return $this->hasMany(ScheduleGroup::class);
    }

    /**
     * Get the service types.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviceTypes()
    {
        return $this->belongsToMany(ServiceType::class);
    }
}
