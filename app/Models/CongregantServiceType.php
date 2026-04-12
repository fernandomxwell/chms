<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongregantServiceType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'congregant_id',
        'service_type_id',
    ];
}
