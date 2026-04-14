<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    abstract public function getSearchable(): array;

    /**
     * Scope a query to only searched request.
     */
    public function scopeSearchBy(Builder $query, array $request): Builder
    {
        return $query->searchByKeyword($request);
    }

    /**
     * Scope a query to only searched keyword.
     */
    public function scopeSearchByKeyword(Builder $query, array $request): Builder
    {
        if (isset($request['search']) && filled($request['search'])) {
            $query->where(function (Builder $_query) use ($request) {
                $searchables = $this->getSearchable();

                return $_query->where(array_pop($searchables), 'like', "%{$request['search']}%")
                    ->when(!empty($searchables), function (Builder $__query) use ($searchables, $request) {
                        foreach ($searchables as $searchable) {
                            $__query->orWhere($searchable, 'like', "%{$request['search']}%");
                        }

                        return $__query;
                    });
            });
        }

        return $query;
    }
}
