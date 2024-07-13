<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function cadastro(Request $request)
    {
        $cliente = new ClienteModel();

        $cliente->nome  = $request->nome;
        $cliente->email = $request->email;
        $cliente->cpf_cnpj = $request->cpf_cnpj;
        $cliente->telefone = $request->telefone;
        $cliente->cliente_ativo = 1;
        $cliente->id_user = $request->id_user;

        if($cliente->save()){
            return  response()->json([ 'message' => "Cliente cadastrado com sucesso"], 201);
        }else {
            return  response()->json([ 'error' => "Falha ao cadastrar cliente"], 500);
        }
    }
}
