<?php

namespace App\Http\Actions;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HandlePaginationAction
{

    /**
     * Método para filtrar models com paginação
     * @param Request $request;
     * @param Model $model
     * @param array $searchColumns
     * @return Model;
     */
    public static function execute(Request $request, Model $model, array $searchColumns = []){

        //Verifica os atributos do SELECT
        $attributes = $request->get('attributes') ?? '*';
        $response = $model::selectRaw($attributes);

        $search = $request->get('search') ?? null;
        if ($search) {
            foreach ($searchColumns as $column) {
                $response->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$search}%"]);
            }
        }

        $filters = $request->get('filters') ?? null;
        if ($filters) {
            $filters = explode(';', $request->get('filters'));

            foreach ($filters as $key => $filter) {
                $conditions = explode(':', $filter);
                $response->where(DB::raw("UPPER({$conditions[0]})"), $conditions[1], strtoupper($conditions[2]));
            }
        }

        if($request->has('filtersOr')){
            if($request->get('filtersOr')) {
                $filters = explode(';', $request->get('filtersOr'));

                foreach ($filters as $key => $filter) {
                    $conditions = explode(':', $filter);
                    $response->orWhere(DB::raw("UPPER({$conditions[0]})"), $conditions[1], strtoupper($conditions[2]));
                }
            }
        }

        $filtersIn = $request->get('filtersIn') ?? null;
        if ($filtersIn) {
            $filters = explode(';', $request->get('filtersIn'));

            foreach ($filters as $key => $filter) {
                $conditions = explode(':', $filter);
                $arrayKey = explode(',', $conditions[1]);
                $response->whereIn($conditions[0], $arrayKey);
            }
        }

        $direction = $request->get('direction') ?? 'asc';
        $sort = $request->get('sort') ?? null;

        if ($sort) {
            $response->orderBy($sort, $direction);
        }

        // Obter relacionamentos
        if ($request->get('relations')) {
            $relations = explode(';', $request->get('relations'));
            foreach ($relations as $relation) {
                $attrs = $relation;
                $response->with($attrs);
            }
        }

        return $response;

    }

}
