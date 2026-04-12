<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongregantActivities extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'congregant_id',
        'activity_id',
    ];
}
