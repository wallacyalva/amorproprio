<?php

namespace App\Http\Controllers;

use App\Http\Actions\HandlePaginationAction;
use App\Http\Requests\ActivityStoreRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\DefaultPaginationRequest;
use App\Http\Utils\SanitizeUtil;
use App\Models\Activity;
use App\Services\MensageService;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefaultPaginationRequest $request, Activity $activity)
    {
        $item = (object) $request->validated();

        $searchColumns = ['title'];
        $response = HandlePaginationAction::execute($request, $activity, $searchColumns);
        
        $activities = $response->paginate($item->limit ?? 10);
        
        return MensageService::sucess("Atividade retornadas.",$response->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $attributes =  $request->validated();

            $activity = Activity::create($attributes);
            $description = "Atividade {$activity->id} {$activity->title} criada.";

            DB::commit();

            return MensageService::sucess($description,$activity);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $id = SanitizeUtil::sanitizeInt($id);
        
        $activity = Activity::find($id);

        if (!$activity) {
            return MensageService::error("Atividade {$id} não encontrada.",404);
        }

        return MensageService::sucess("Atividade {$activity->id} {$activity->title} encontrada.",$activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityUpdateRequest $request, int $id)
    {
        $attributes =  $request->validated();
        $id = SanitizeUtil::sanitizeInt($id);
        
        $activity = Activity::find($id);
        
        if (!$activity) {
            return MensageService::error("Atividade com o código {$id} não encontrada.",404);
        }
        
        try {
            DB::beginTransaction();

            $activity->update($attributes);
            $description = "Atividade {$activity->id} {$activity->title} editada.";

            DB::commit();
            return MensageService::sucess($description,$activity);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $id = SanitizeUtil::sanitizeInt($id);
        
        $activity = Activity::find($id);

        if (!$activity) {
            return MensageService::error("Atividade com o código {$id} não encontrada.",404);
        }

        try {
            DB::beginTransaction();

            $activity->delete();
            $description = "Atividade {$activity->id} {$activity->title} excluída.";

            DB::commit();
            return MensageService::sucess($description);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }
}