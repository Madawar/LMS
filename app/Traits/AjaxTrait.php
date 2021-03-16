<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 1/14/19
 * Time: 10:12 AM
 */

namespace App\Traits;


trait AjaxTrait
{
    public function ajax($request, $query, $relatedColumns = [])
    {
        $query->when($request->ajax(), function ($q, $filter) use ($request, $query, $relatedColumns) {
            $query->when(request('house_id', false), function ($q, $id) {
                return $q->where('house_id', $id);
            });
            //Filter Columns
            $query->when(request('filter', false), function ($q, $filter) use ($relatedColumns) {
                return $q->search($filter, $relatedColumns);

            });
            //Scope
            $query->when(request('scope', false), function ($q, $scope) {
                return $q->$scope();
            });
            //Sort
            $query->when(request('sort', false), function ($q, $sortBy) {
                $params = explode("|", $sortBy);
                return $q->orderBy($params[0], $params[1]);
            });
            return $query->paginate($request->per_page);
        });
        return $query;
    }
}
