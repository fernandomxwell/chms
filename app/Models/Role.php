<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use Searchable;

    protected $fillable = ['name', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function getSearchable(): array
    {
        return ['name'];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
