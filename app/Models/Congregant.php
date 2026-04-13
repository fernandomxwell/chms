<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Congregant extends Model
{
    use Searchable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'gender',
        'date_of_birth',
        'phone_number',
        'email',
        'date_of_baptism',
        'status',
        'can_serve_consecutively',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_baptism' => 'date',
    ];

    /**
     * Get the searchable attributes
     */
    public function getSearchable(): array
    {
        return [
            'full_name',
            'email',
            'phone_number',
        ];
    }

    /**
     * Get the date of birth in 'Y-m-d', e.g.: 2025-05-18.
     *
     * @return string
     */
    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : null;
    }

    /**
     * Get the date of baptism in 'Y-m-d', e.g.: 2025-05-18.
     *
     * @return string
     */
    public function getFormattedDateOfBaptismAttribute()
    {
        return $this->date_of_baptism ? $this->date_of_baptism->format('Y-m-d') : null;
    }

    public function getActivitiesAttribute()
    {
        return $this->serviceTypesPivot()
            ->with('activity')
            ->get()
            ->pluck('activity')
            ->filter()
            ->unique('id')
            ->values();
    }

    /**
     * Get the serviceTypes.
     *
     * @return BelongsToMany
     */
    public function serviceTypes()
    {
        return $this->belongsToMany(ServiceType::class, 'congregant_activity_service_types')
            ->withPivot('activity_id');
    }

    public function serviceTypesPivot(): HasMany
    {
        return $this->hasMany(CongregantActivityServiceType::class);
    }

    /**
     * Get the schedules.
     *
     * @return BelongsToMany
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'congregant_schedules');
    }
}
