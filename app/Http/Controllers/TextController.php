<?php

namespace App\Http\Controllers;

use App\Http\Actions\HandlePaginationAction;
use App\Http\Requests\DefaultPaginationRequest;
use App\Http\Requests\TextStoreRequest;
use App\Http\Requests\TextUpdateRequest;
use App\Http\Utils\SanitizeUtil;
use App\Models\Text;
use App\Services\MensageService;
use Illuminate\Support\Facades\DB;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefaultPaginationRequest $request, Text $text)
    {
        $item = (object) $request->validated();

        $searchColumns = ['name'];
        $response = HandlePaginationAction::execute($request, $text, $searchColumns);
        
        $texts = $response->paginate($item->limit ?? 10);
        
        return MensageService::sucess("Testo retornados.",$response->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TextStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $attributes =  $request->validated();
            
            $text = Text::create($attributes);
            $description = "Testo {$text->id} {$text->name} criado.";
            DB::commit();

            return MensageService::sucess($description,$text);
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
        
        $text = Text::find($id);

        if (!$text) {
            return MensageService::error("Testo {$id} não encontrado.",404);
        }

        return MensageService::sucess("Testo {$text->id} {$text->name} encontrado.",$text);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TextUpdateRequest $request, int $id)
    {
        $attributes =  $request->validated();
        $id = SanitizeUtil::sanitizeInt($id);
        
        $text = Text::find($id);
        
        if (!$text) {
            return MensageService::error("Testo com o código {$id} não encontrado.",404);
        }
        
        try {
            DB::beginTransaction();

            $text->update($attributes);
            $description = "Testo {$text->id} {$text->name} editado.";

            DB::commit();
            return MensageService::sucess($description,$text);
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
        
        $text = Text::find($id);

        if (!$text) {
            return MensageService::error("Testo com o código {$id} não encontrado.",404);
        }

        try {
            DB::beginTransaction();

            $text->delete();
            $description = "Testo {$text->id} excluído.";

            DB::commit();
            return MensageService::sucess($description);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }
}