<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'link',
        'actions',
        'order',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'actions' => 'array',
    ];

    /**
     * Get the name in snake case.
     *
     * @return string
     */
    public function getNameInSnakeCaseAttribute()
    {
        return Str::snake($this->name);
    }

    /**
     * Scope a query to only include parent menu.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get the children menus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->with('children')
            ->select([
                'id',
                'parent_id',
                'name',
                'link',
            ]);
    }
}
