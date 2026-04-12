<?php

namespace App\Traits\Models;

trait Searchable
{
    abstract public function getSearchable(): array;

    /**
     * Scope a query to only searched request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array $request
     * @return \Illuminate\Database\Eloquent\Builder type
     */
    public function scopeSearchBy($query, array $request)
    {
        return $query->searchByKeyword($request);
    }

    /**
     * Scope a query to only searched keyword.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByKeyword($query, array $request)
    {
        if (isset($request['search']) && filled($request['search'])) {
            $query->where(function ($_query) use ($request) {
                $searchables = $this->getSearchable();

                return $_query->where(array_pop($searchables), 'like', "%{$request['search']}%")
                    ->when(!empty($searchables), function ($__query) use ($searchables, $request) {
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
