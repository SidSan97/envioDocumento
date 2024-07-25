<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\UsuarioController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/cadastrar-cliente', [ClienteController::class, 'cadastro']);
Route::post('/enviar-documento', [UsuarioController::class, 'envioDocumento']);
Route::get('/obter-documentos/{id}', [UsuarioController::class, 'obterDocumentos']);
Route::post('/alterar-senha', [UsuarioController::class, 'alterarSenha']);
Route::get('/listar-colaboradores', [UsuarioController::class, 'listarColaboradores']);
Route::get('/listar-clientes/{id}', [UsuarioController::class, 'listarClientes']);

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Credenciais Inválidas'], 401);
    }

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => [
            'id' => $user->id_user,
            'name' => $user->name,
            'id_cargo' => $user->id_cargo,
            'first_login' => $user->first_login
        ]
    ]);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Deslogado com sucesso!']);
});


