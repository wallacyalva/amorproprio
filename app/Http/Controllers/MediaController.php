<?php

namespace App\Http\Controllers;

use App\Http\Actions\HandlePaginationAction;
use App\Http\Requests\DefaultPaginationRequest;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Utils\SanitizeUtil;
use App\Models\Media;
use App\Services\MensageService;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefaultPaginationRequest $request, Media $media)
    {
        
        $item = (object) $request->validated();

        $searchColumns = ['title'];
        $response = HandlePaginationAction::execute($request, $media, $searchColumns);
        
        $media = $response->paginate($item->limit ?? 10);
        
        return MensageService::sucess("Midia retornadas.",$response->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediaStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $attributes =  $request->validated();

            $media = Media::create($attributes);
            $description = "Midia {$media->id} {$media->title} criada.";
            DB::commit();

            return MensageService::sucess($description,$media);
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
        
        $media = Media::find($id);

        if (!$media) {
            return MensageService::error("Midia {$id} não encontrada.",404);
        }

        return MensageService::sucess("Midia {$media->id} {$media->title} encontrada.",$media);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediaUpdateRequest $request, int $id)
    {
        $attributes =  $request->validated();
        $id = SanitizeUtil::sanitizeInt($id);
        
        $media = Media::find($id);
        
        if (!$media) {
            return MensageService::error("Midia com o código {$id} não encontrada.",404);
        }
        
        try {
            DB::beginTransaction();

            $media->update($attributes);
            $description = "Midia {$media->id} {$media->title} editada.";

            DB::commit();
            return MensageService::sucess($description,$media);
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
        
        $media = Media::find($id);

        if (!$media) {
            return MensageService::error("Midia com o código {$id} não encontrada.",404);
        }

        try {
            DB::beginTransaction();

            $media->delete();
            $description = "Midia {$media->id} excluída.";

            DB::commit();
            return MensageService::sucess($description);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }
}