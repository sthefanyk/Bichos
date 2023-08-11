<?php

use App\Http\Controllers\Api\PersonalidadeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/personalidades', PersonalidadeController::class);

Route::get('/', function(){
    return response()->json(['menssage' => 'success']);
});
