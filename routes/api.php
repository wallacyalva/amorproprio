    <?php

    use App\Http\Controllers\ActivityController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\MediaController;
    use App\Http\Controllers\PostController;
    use App\Http\Controllers\TextController;
    use Illuminate\Support\Facades\Route;

    //Rotas publicas do sistema (public)
    Route::prefix('/public')->group(function () {
        Route::get('media', [MediaController::class, 'index']);
        Route::get('post', [PostController::class, 'index']);
        Route::get('activity', [ActivityController::class, 'index']);
        Route::get('text', [TextController::class, 'index']);
    });

    // Rota auth para logar no sistema (login)
    Route::prefix('/auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
});

//Rotas logadas que exige esta logado no sistema (logada)
Route::prefix('/v1')->middleware('auth:api')->group(function () {

    Route::get('logout',  [AuthController::class, 'logout']);
    Route::get('refresh',  [AuthController::class, 'refresh']);
    Route::get('me',  [AuthController::class, 'me']);
    
    Route::apiResource('media', MediaController::class);
    Route::apiResource('post', PostController::class);
    Route::apiResource('activity', ActivityController::class);
    Route::apiResource('text', TextController::class);
});
