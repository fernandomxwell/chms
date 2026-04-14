<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CongregantActivityServiceType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'congregant_id',
        'service_type_id',
        'activity_id',
    ];

    /**
     * Get the congregant.
     */
    public function congregant(): BelongsTo
    {
        return $this->belongsTo(Congregant::class);
    }

    /**
     * Get the service type.
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * Get the activity.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
