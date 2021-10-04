<?php

namespace Illusi03\LaraSearch;

/**
 * Advanced model and relationships search for Laravel
 *
 * @package LaraSearch
 * @author Anonymous
 */
class LaraSearch
{
    /**
     * Main process
     *
     * @param string $search
     * @param Illuminate\Database\Eloquent\Builder $builder
     * @param array $searchSchema
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function find($search, $builder, $searchSchema)
    {
        // Remove special characters and split the search
        $cleanSearch = preg_replace('/[^ \w]+/', ' ', $search);
        $cleanSearch = str_replace('  ', ' ', $cleanSearch);
        $results = $builder->where(function ($query) use ($cleanSearch, $searchSchema) {
            self::laraSearch($query, $cleanSearch, [$searchSchema]);
        });
        return $results;
    }

    private static function laraSearch($query, $searchTerm, $currentLevel)
    {
        // For other DB
        // $query->orWhere($attribute, 'ILIKE', "%{$searchTerm}%");
        foreach ($currentLevel as $model) {
            foreach ($model['fields'] as $field) {
                if (!isset($model['relationship'])) {
                    $searchTerm = strtolower($searchTerm);
                    if (!$query) {
                        $query->where(DB::raw("lower($field)"), "like", "%" . $searchTerm . "%");
                    } else {
                        $query->orWhere(DB::raw("lower($field)"), "like", "%" . $searchTerm . "%");
                    }
                } else {
                    $query->orWhereHas($model['relationship'], function ($relQuery) use ($searchTerm, $field) {
                        $relQuery->where(DB::raw("lower($field)"), "like", "%" . $searchTerm . "%");
                    });
                }
            }
            if (isset($model['relationships'])) {
                self::laraSearch($query, $searchTerm, $model['relationships']);
            }
        }
        return $query;
    }
}
