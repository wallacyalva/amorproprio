<?php

namespace App\Http\Controllers;

use App\Http\Actions\HandlePaginationAction;
use App\Http\Requests\DefaultPaginationRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Utils\SanitizeUtil;
use App\Models\Post;
use App\Services\MensageService;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefaultPaginationRequest $request, Post $post)
    {
        $item = (object) $request->validated();

        $searchColumns = ['mensage'];
        $response = HandlePaginationAction::execute($request, $post, $searchColumns);
        
        $posts = $response->paginate($item->limit ?? 10);
        
        return MensageService::sucess("Poste retornados.",$response->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $attributes =  $request->validated();

            $post = Post::create($attributes);
            $description = "Poste {$post->id} {$post->mensage} criado.";
            DB::commit();

            return MensageService::sucess($description,$post);
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
        
        $post = Post::find($id);

        if (!$post) {
            return MensageService::error("Poste {$id} não encontrado.",404);
        }

        return MensageService::sucess("Poste {$post->id} {$post->mensage} encontrado.",$post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, int $id)
    {
        $attributes =  $request->validated();
        $id = SanitizeUtil::sanitizeInt($id);
        
        $post = Post::find($id);
        
        if (!$post) {
            return MensageService::error("Poste com o código {$id} não encontrado.",404);
        }
        
        try {
            DB::beginTransaction();

            $post->update($attributes);
            $description = "Poste {$post->id} {$post->mensage} editado.";

            DB::commit();
            return MensageService::sucess($description,$post);
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
        
        $post = Post::find($id);

        if (!$post) {
            return MensageService::error("Poste com o código {$id} não encontrado.",404);
        }

        try {
            DB::beginTransaction();

            $post->delete();
            $description = "Poste {$post->id} excluído.";

            DB::commit();
            return MensageService::sucess($description);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MensageService::throwable($th);
        }
    }
}