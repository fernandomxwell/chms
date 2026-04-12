<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongregantSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_id',
        'congregant_id',
    ];
}
