<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
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
    ];

    /**
     * Get the attributes that should be hidden.
     *
     * @return array<string, string>
     */
    protected $hidden = [
        'pivot',
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
     * Get the congregants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function congregants()
    {
        return $this->belongsToMany(Congregant::class, 'congregant_service_types');
    }

    /**
     * Get the activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
