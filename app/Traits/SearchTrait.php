<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 1/13/19
 * Time: 10:08 AM
 */

namespace App\Traits;


use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
trait SearchTrait
{
    public function scopeSearch($query, $keyword, $relativeTables = [], $columns = [])
    {
        if (empty($columns)) {
            $columns = Arr::except(
                Schema::getColumnListing($this->getTable()), $this->guarded
            );
        }

        $query->where(function ($query) use ($keyword, $columns, $relativeTables) {
            foreach ($columns as $key => $column) {
                $clause = $key == 0 ? 'where' : 'orWhere';
                $query->$clause($column, "LIKE", "%$keyword%");
                if (!empty($relativeTables)) {
                    $this->filterByRelationship($query, $keyword, $relativeTables);
                }
            }
        });

        return $query;
    }


    private function filterByRelationship($query, $keyword, $relativeTables)
    {
        foreach ($relativeTables as $relationship => $relativeColumns) {
            $query->orWhereHas($relationship, function ($relationQuery) use ($keyword, $relativeColumns) {
                foreach ($relativeColumns as $key => $column) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $relationQuery->$clause($column, "LIKE", "%$keyword%");
                }
            });
        }

        return $query;
    }
}
