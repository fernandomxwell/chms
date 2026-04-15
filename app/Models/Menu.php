<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;
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
     */
    public function getNameInSnakeCaseAttribute(): string
    {
        return Str::snake($this->name);
    }

    /**
     * Get translated name from route name.
     */
    public function getTranslatedNameAttribute(): string
    {
        if (!empty($this->link) && Lang::has("{$this->link}")) {
            return __("{$this->link}");
        }

        return __("{$this->name_in_snake_case}.index");
    }

    /**
     * Scope a query to only include parent menu.
     */
    public function scopeParent(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get the children menus.
     */
    public function children(): HasMany
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

    /**
     * Get the parent menu.
     */
    public function parents(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id')
            ->with('parents')
            ->select([
                'id',
                'parent_id',
                'name',
                'link',
            ]);
    }
}
