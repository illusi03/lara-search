<?php

namespace Illusi03\LaraSearch\Traits;

use Illusi03\LaraSearch\LaraSearch;

trait LaraSearchable {

    public function scopeLaraSearch($query, $search, array $fields, array $relationFields = [])
    {
        $searchSchema = [
            'fields' => $fields,
            'relationships' => []
        ];

        foreach ($relationFields as $relation => $fields) {
            $searchSchema['relationships'][] = [
                'relationship' => $relation,
                'fields' => !is_array($fields) ? [$fields] : $fields,
            ];
        }

        return LaraSearch::find($search, $query, $searchSchema);
    }

}
